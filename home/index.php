<!DOCTYPE html>
<?php
include "../includes/core.php";
include CONFIG_COMMON_PATH . "includes/home.php";

if (CONFIG_REQUIRE_AUTHENTICATION)
	include CONFIG_COMMON_PATH."includes/auth.php";
if (CONFIG_HOOYA_PATH) {
	include CONFIG_HOOYA_PATH."includes/config.php";
	include CONFIG_HOOYA_PATH."includes/users.php";
	include CONFIG_HOOYA_PATH."includes/render.php";
}

if (isset($_GET['picture'], $_GET['id']))
if ($_GET['id'] == $_SESSION['userid']) {
	update_userpicture($_SESSION['userid'], $_GET['picture']);
}
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bigmike — home</title>
</head>
<body>
<div id="container">
<div id="leftframe">
	<nav><?php print_login();?></nav>
	<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe" class='userpage'>
<?php
	if (isset($_GET['id'])) {
		$id = (int)$_GET['id'];
		$username = get_username($id);
		$tagcount = get_usertagcount($id);
		$userpicture = get_userpicture($id);
		if (!$userpicture)
			$userpicture = 'ed083cf55c0598e29e072feca85a7993';
		$lastactivity = get_lastuseractivity($id);
		print '<div class=summary>'
		. '<span><a href=.>back</a> to all users</span>'
		. '<img '
		. "src=" . CONFIG_HOOYA_WEBPATH . "download.php?key=$userpicture&thumb></img>";
		if ($id == $_SESSION['userid'])
			print "<form><input value=$userpicture placeholder='hooYa! picture id'"
			. " style='width:100%' name=picture>"
			.  "<input type=hidden name=id value=$id></form>";
		if ($lastactivity) {
			print "<span>Last Online $lastactivity</span>";
		}
		print '</div>'
		. '<main class=details>'
		. "<h1 style='text-align:center;word-wrap:break-word'>$username";
		if ($id == $_SESSION['userid'])
			print " (you)";
		print '</h1>'
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
		. '</main>';
	} else {
		print'<main style="display:flex;flex-wrap:wrap;align-items:center;">';
		foreach (get_users() as $id => $info) {
			if (!$info['picture']) $info['picture'] = 'ed083cf55c0598e29e072feca85a7993';
			print "<div style='padding:10px;display:flex;flex-direction:column;align-items:center;'>"
			. $info['username']
			. "<a href=?id=$id>"
			. "<img style='max-width: 150px' src=" . CONFIG_HOOYA_WEBPATH
			. "download.php?key=" . $info['picture'] . "&thumb></img></a>"
			. "</div>";
		}
		print '</main>';
	}
?>
</div>
</div>
<?php if (isset($_GET['picture']))
	print '<script>window.history.back();</script>';
?>
</body>
</HTML>
