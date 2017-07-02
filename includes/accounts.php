<?php
function account_create($username, $password)
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
	$cmd = "INSERT INTO `users` (username, password) VALUES ('" . $username."','".$salted_password."')";
	$conn->query($cmd);
	return true;
}
?>