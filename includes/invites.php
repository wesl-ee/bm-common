<?php
function invites_generate($userid)
{
	// Generate a random password and salt
	$key = randomhex(60);
	$hash = hash('sha512', $key);

	// Keep the hashed key in the database for later checking
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "INSERT INTO invites (`hash`, `ownerid`) VALUES ('".$hash."',".$userid.")";
	$conn->query($cmd);
	return $key;
}
function invites_validate($key)
{
	// Generate the hash to check against
	$hash = hash('sha512', $key);

	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "SELECT `hash` FROM `invites` WHERE `hash` = '".$hash."'";
	$result=$conn->query($cmd);
	if ($result->num_rows == 0) {
		return false;
	}
	return true;
}
function invites_delete($key)
{
	// Generate the hash to delete
	$hash = hash('sha512', $key);

	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "DELETE FROM `invites` WHERE `hash` = '".$hash."'";
	$conn->query($cmd);
	return true;
}
function invites_cangenerate($userid)
{
	$cutoff = date('Y-m-d H:i:s', strtotime(' -7 days'));
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "SELECT `hash` FROM `invites` WHERE `date_created` > '".$cutoff."'";
	$result = $conn->query($cmd);
	if ($result->num_rows != 0) {
		return false;
	}
	return true;
}
function invites_clean()
{
	$cutoff = date('Y-m-d H:i:s', strtotime(' -'.CONFIG_INVITE_COOLDOWN));
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "DELETE FROM `invites` WHERE `date_created` < '".$cutoff."'";
	$conn->query($cmd);
}
function invites_nexttime()
{
	$cutoff = date('Y-m-d H:i:s', strtotime(' -'.CONFIG_INVITE_COOLDOWN));
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "SELECT `date_created` FROM `invites` WHERE `date_created` > '".$cutoff."' ORDER BY `date_created` ASC ";
	$result = $conn->query($cmd);
	if ($result->num_rows == 0) {
		return false;
	}
	$row = $result->fetch_assoc();

	$nexttime = date('D M d Y H:i:s O', strtotime($row["date_created"].' +'.CONFIG_INVITE_COOLDOWN));
	return $nexttime;
}
?>