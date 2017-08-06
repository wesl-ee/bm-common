<?php
function account_create($username, $password, $invited_by = NULL)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$username = mysqli_escape_string($dbh, $username);
	$password = mysqli_escape_string($dbh, $password);

	// Duplicate username detection
	$res = mysqli_query($dbh, "SELECT `username` FROM `users`"
	. " WHERE `username`='$username'");
	if (mysqli_num_rows($res)) {
		syslog(LOG_INFO|LOG_DAEMON, "Attempted to create a duplicate"
		. " user $username from " . $_SERVER['REMOTE_ADDR']);
		return false;
	}

	// Duplicate IP address detection
	$res = mysqli_query($dbh, "SELECT `username` FROM `users`"
	. " WHERE `last_ip`='" . $_SERVER['REMOTE_ADDR'] . "'");
	print("SELECT `username` FROM `users`"
        . " WHERE `last_ip`='" . $_SERVER['REMOTE_ADDR'] . "'");
	if (mysqli_num_rows($res)) {
		syslog(LOG_INFO|LOG_DAEMON, "Attempted to same-ip register"
		. " $username from " . $_SERVER['REMOTE_ADDR']);
		return false;
	}

	// Register the requested username and password
	$salt = randomHex(16);
	$hash = $password;
	// make a crypt(3) formatted hash+salt
	$hash = crypt($hash, '$6$'.$salt.'$');
	$salted_password = $hash;
	mysqli_query($dbh, "INSERT INTO `users`"
	. " (`username`, `password`, `last_ip`) VALUES"
	. " ('$username', '$salted_password'"
	. ", '" . $_SERVER['REMOTE_ADDR'] . "')");

	if (isset($invited_by)) {
		mysqli_query("UPDATE `users` SET"
		. " `invited_by`='$invited_by'"
		. " WHERE username='$username'");
	}
	mysqli_close($dbh);
	return true;
}
function login_validate($username, $password)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$username = mysqli_escape_string($dbh, $username);
	$password = mysqli_escape_string($dbh, $password);
	$res = mysqli_query($dbh, "SELECT"
	. " `id`, `username`, `password`, `failed_logins`, `last_ip`"
	. ", `last_login`, `pref_css` FROM `users`"
	. "  WHERE username='$username'");
	$row = mysqli_fetch_assoc($res);
	if (!$row) {
		syslog(LOG_INFO|LOG_DAEMON, "Failed log-in attempt for"
		. " invalid user $username from " . $_SERVER['REMOTE_ADDR']);
		return false;
	}

	if (!password_verify($password, $row['password'])) {
		// Update the number of failed logins
		$row['failed_logins']++;
		$cmd = "UPDATE `onsen` SET `failed_logins`='$failed_logins' WHERE `username`='$sql_username'";
		mysqli_query($dbh, "UPDATE `users` SET"
		. " `failed_logins`=$failed_logins"
		. " WHERE `username`='$username'");

		syslog(LOG_INFO|LOG_DAEMON, "Failed log-in attempt for" 
		. " $username from " . $_SERVER['REMOTE_ADDR']);
		return false;
	}

	syslog(LOG_INFO|LOG_DAEMON, "Successful login for"
	. " $username from " . $_SERVER['REMOTE_ADDR']);


	// Initialize the user's session
	$_SESSION['userid'] = $row['id'];
	$_SESSION['username'] = $username;

	// Reset the number of failed login attempts
	mysqli_query("UPDATE `users` SET `failed_logins`=0"
	. " WHERE `id`=" . $_SESSION['userid']);

	// Update the styling sheets for our session
	$_SESSION['pref_css'] = $row['pref_css'];
	reloaduserstyle();

	// Update 'last login' information to the current session
	$today = date("Y-m-d H:i:s");
	mysqli_query($dbh, "UPDATE `users` SET `last_login`='$today'"
	. ", `last_ip`='" . $_SERVER['REMOTE_ADDR'] . "'"
	. " WHERE `id` = " . $_SESSION['userid']);

	return [
		'last_login' => $row['last_login'],
		'last_ip' => $row['last_ip'],
		'failed_logins' => $row['failed_logins'],
	];
}
?>
