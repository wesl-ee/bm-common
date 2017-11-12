<?php
function get_users()
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$query = "SELECT users.id AS id, username, MAX(last_activity) AS last_activity,"
	. " `picture` AS picture FROM identity, users WHERE"
	. " identity.id = users.id GROUP BY users.id ORDER BY last_activity DESC";
	$res = mysqli_query($dbh, $query);
	while ($row = mysqli_fetch_assoc($res)) {
		$ret[$row['id']] = [
			'username' => $row['username'],
			'last_activity' => $row['last_activity'],
			'picture' => $row['picture']
		];
	}
	return $ret;
}
function get_lastuseractivity($id)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$query = "SELECT id, MAX(last_activity) AS date FROM `identity` WHERE"
	. " `id` = $id";
	$res = mysqli_query($dbh, $query);
	$row = mysqli_fetch_assoc($res);
	return $row['date'];
}
function get_userpicture($id)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$query = "SELECT picture FROM `users` WHERE"
	. " `id` = $id";
	$res = mysqli_query($dbh, $query);
	$row = mysqli_fetch_assoc($res);
	return $row['picture'];
}
function update_userpicture($id, $key)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$key = mysqli_real_escape_string($dbh, $key);
	$query = "SELECT picture FROM `users` WHERE"
	. " `id` = $id";
	$res = mysqli_query($dbh, $query);
	$oldpicture = mysqli_fetch_assoc($res)['picture'];
	unlink($oldpicture);
	$query  = "UPDATE `users` SET `picture`='$key' WHERE `id`=$id";
	return mysqli_query($dbh, $query);
}
?>
