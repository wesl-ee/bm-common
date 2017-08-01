<?php
function account_create($username, $password, $invited_by = NULL)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$username = mysqli_escape_string($dbh, $username);
	$password = mysqli_escape_string($dbh, $password);
	$res = mysqli_query($dbh, "SELECT `username` FROM `users`"
	. " WHERE `username`='" . $username . "'");
	if (mysqli_num_rows($res)) {
		return false;
	}
	$salt = randomHex(16);
	$hash = $password;
	$hash = crypt($hash, '$6$'.$salt.'$');
	$salted_password = $hash;
	$query = "INSERT INTO `users` (username, password, invited_by) VALUES ('" . $username."','".$salted_password."','".$invited_by."')";
	mysqli_query($dbh, "INSERT INTO `users`"
	. " (`username`, `password`, `invited_by`) VALUES"
	. " ('$username', '$salted_password', '$invited_by')");
	return true;
}
function login_validate($username, $password)
{
}
?>
