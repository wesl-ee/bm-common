<?php
// Is the user in the wheel group?
function db_isAdmin($userid)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
	CONFIG_DB_USERNAME,
	CONFIG_DB_PASSWORD,
	CONFIG_DB_DATABASE);
	if (mysqli_connect_errno()) die("Could not connect to mysql server");

	$query = 'SELECT 1 FROM users, membership, groups
	WHERE users.id='.$userid.'
	AND membership.userid=users.id
	AND groups.id=membership.groupid
	AND groups.name="wheel"';

	$res = mysqli_query($dbh, $query);
	if (mysqli_error($dbh)) die(mysqli_error($dbh));
	$row = mysqli_fetch_assoc($res);
	return $row[1];
}
function db_isInGroup($userid, $groupid)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
	CONFIG_DB_USERNAME,
	CONFIG_DB_PASSWORD,
	CONFIG_DB_DATABASE);
	if (mysqli_connect_errno()) die("Could not connect to mysql server");

	$query = 'SELECT 1 FROM users, membership, groups
	WHERE users.id='.$userid.'
	AND membership.userid=users.id
	AND groups.id=membership.groupid
	AND groups.id='.$groupid;

	$res = mysqli_query($dbh, $query);
	if (mysqli_error($dbh)) die(mysqli_error($dbh));
	$row = mysqli_fetch_assoc($res);
	return $row[1];
}
// Returns an associative array of groupnames => group_ids
function db_getGroupIDs()
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
	CONFIG_DB_USERNAME,
	CONFIG_DB_PASSWORD,
	CONFIG_DB_DATABASE);
	if (mysqli_connect_errno()) die("Could not connect to mysql server");
	$query = 'SELECT groups.id,groups.name FROM groups';
	$res = mysqli_query($dbh, $query);
	if (mysqli_error($dbh)) die(mysqli_error($dbh));
	while ($row = mysqli_fetch_assoc($res)) {
		$groupID[$row['name']] = $row['id'];
	}
	mysqli_close($dbh);
	return $groupID;
}
// Returns an associative array of user_ids => usernames
function db_getUsernames()
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
	CONFIG_DB_USERNAME,
	CONFIG_DB_PASSWORD,
	CONFIG_DB_DATABASE);
	if (mysqli_connect_errno()) die("Could not connect to mysql server");
	$query = 'SELECT users.username,users.id FROM users';
	$res = mysqli_query($dbh, $query);
	if (mysqli_error($dbh)) die(mysqli_error($dbh));
	while ($row = mysqli_fetch_assoc($res)) {
		$userID[$row['id']] = $row['username'];
	}
	mysqli_close($dbh);
	return $userID;
}
?>