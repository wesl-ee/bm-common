<?php
function render_usersummary($id, $username, $picture)
{
	print "<div class=userblock>"
	. $username
	. "<a href=?id=$id>"
	. "<img style='max-width: 150px' src='$picture'>"
	. "</img></a>"
	. "</div>";
}
// Cleanup later, lots of SQL calls because I am lazy
function render_userpage($id)
{
	$username = get_username($id);
	$tagcount = get_usertagcount($id);
	$userpicture = get_userpicture($id);
	if (!$userpicture)
		$userpicture = 'users/vsauce-michael.jpg';
	$userpicturepath = CONFIG_COMMON_WEBPATH . "home/$userpicture";
	$lastactivity = date('F j, Y, g:ia', strtotime(get_lastuseractivity($id)));
	$joindate = date('F j, Y, g:ia', strtotime(get_joindate($id)));
	print '<header><span><a href=.>all users</a></span>';
	print "<h1>$username";
	if ($id == $_SESSION['userid'])
		print "	(you)";
	print '</h1></header>'
	. '<main>'
	. '<div class=summary>';
	if ($id == $_SESSION['userid'])
		print "<form method=post enctype='multipart/form-data'>"
		.  "<input type=hidden name=id value=$id>"
		. "<input style='display:none' type=file"
		. " name=picture id=fupload>"
		. "<label style='cursor:pointer;'title='Click to change"
		. " your picture!' id=flabel for=fupload>";
	print '<div><img '
	. "src='$userpicturepath'></div>";
	if ($id == $_SESSION['userid'])
		print '</label></form>';
	print "<span>Joined on $joindate</span>";
	if ($lastactivity) {
		print "<span>Last Online $lastactivity</span>";
	}
	if ($id == $_SESSION['userid'])
		print '<a href="../util/change_passwd.php">Change password</a>'
		. '<a href="../util/invite.php">Invite a friend</a>'
		. '<a href="../util/acc_delete.php">Delete your account</a>';
	print '</div>'
	. '<dl>';
	if (CONFIG_HOOYA_PATH) {
		if ($tagcount > 0) {
			print '<dt>Pictures Tagged</dt>'
			. "<dd>$tagcount</dd>";
			$favoritetags = get_userfavorites($id, 5);
			render_bargraph($favoritetags);
		} else print "No tags added yet!";
	}
	print '</dl>'
	. '</main>'
	. '</div>';
}
?>
