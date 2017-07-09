<?php
function account_create($username, $password, $invited_by = NULL)
{
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "SELECT `username` FROM `users` WHERE `username`='".$username."'";
	$result=$conn->query($cmd);
	if ($result->num_rows !== 0) {
		return false;
	}
	$salt = randomHex(16);
	$hash = $password;
	$hash = crypt($hash, '$6$'.$salt.'$');
	$salted_password = $hash;
	$cmd = "INSERT INTO `users` (username, password, invited_by) VALUES ('" . $username."','".$salted_password."','".$invited_by."')";
	$conn->query($cmd);
	return true;
}
function login_validate($username, $password)
{
}
?>
