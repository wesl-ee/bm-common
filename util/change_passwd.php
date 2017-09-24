<!DOCTYPE html>
<?php
include "../includes/core.php";

// Was the user refered by some other link?
if (isset($_GET['ref']))
	$uri = "?ref=".urlencode($_GET['ref']);
if (!isset($_SESSION['userid'])) {
	header("HTTP/1.0 401 Unauthorized");
	header("Location: ".CONFIG_COMMON_WEBPATH."login.php");
die;
}
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php"; ?>
	<title>bm — change password</title>
</head>
<body>
<div id="container">
<div id="leftframe">
	<nav>
		<?php print_login(); ?>
	</nav>
<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
<header>
	<h1 style="text-align:center;">password changes</h1>
</header>
<?php
if (isset($_POST['onsen_curr_password'], $_POST['onsen_new_password'], $_POST['onsen_confirm_password'])) {
	if ($_POST['onsen_new_password'] != $_POST['onsen_confirm_password']) {
		print 'New passwords do not match'; return;
	}
	if (strlen($_POST['onsen_new_password']) > 50) {
		print 'Invalid length for new password~'; return;
	}

	// Fetch and filter the user's form data
	$onsen_username=$_SESSION['username'];
	$onsen_curr_password = filter_var($_POST['onsen_curr_password'], FILTER_SANITIZE_STRING);
	$onsen_new_password = filter_var($_POST['onsen_new_password'], FILTER_SANITIZE_STRING);

	// Hash the new password according to SHA512-CRYPT specification
	$salt = randomHex(16);
	$hash = crypt($onsen_new_password, '$6$'.$salt.'$');

	// SQL connection
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	if ($conn->connect_error) {
		print "It looks like the SQL database is offline"; return;
	}

	$cmd = "SELECT `id`, `password`, `username`, `failed_logins`, `last_login`, `locked`, `pref_css` FROM `users` WHERE `username`='$onsen_username'";
	$result=$conn->query($cmd);
	if (!$result) {
		print "Something went wrong with your request. . . email someone who can fix it"; return;
	}
	$row = $result->fetch_assoc();
	$sql_id = $row["id"];
	$sql_username = $row["username"];
	$sql_password = $row["password"];
	$sql_failed_logins = $row["failed_logins"];
	$sql_locked = $row["locked"];
	$sql_last_login = $row["last_login"];
	$sql_pref_css = $row["pref_css"];

	// Handling incorrect usernames
	if ($result->num_rows === 0) {
		print "I cannot find your account!"; return;
	}
	// Handling locked accounts
	if ($sql_locked == "y") {
		print "Your account is locked, please try again in a few minutes~"; return;
	}

	// Handling incorrect passwords
	if (!password_verify($onsen_curr_password, $sql_password)) {
		print "Your password is incorrect!"; return;
	}
	$salt = randomHex(16);
	$onsen_new_password = crypt($onsen_new_password, '$6$'.$salt.'$');
	$onsen_username = $_SESSION['username'];
	$cmd = "UPDATE `users` SET `password`='$onsen_new_password' WHERE `username`='$sql_username'";
	$conn->query($cmd);

	print "Successfully changed password!<script type='text/javascript'>setTimeout(function () {window.location.href = '../logout.php';}, 2000);</script>";
	die();
}
?>
<div class="entry">
<p>
	<a href="../">« back</a>
</p>
<form method="post">
	<label for="onsen_curr_password">Current password</label></br>
	<input type="password" id="onsen_curr_password" name="onsen_curr_password" value="" maxlength="20" /></br>
	<label for="onsen_new_password">New Password</label></br>
	<input type="password" id="onsen_new_password" name="onsen_new_password" maxlength="50" /></br>
	<label for="onsen_confirm_password">Confirm New Password</label></br>
	<input type="password" id="onsen_confirm_password" name="onsen_confirm_password" maxlength="50" /></br></br>
	<input type="submit" value="Change password »" />
</form>
</div>
</div>
</div>
</body>
</HTML>
