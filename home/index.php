<!DOCTYPE html>
<?php
include "../includes/core.php";
include CONFIG_COMMON_PATH . "includes/home.php";
include CONFIG_COMMON_PATH . "includes/render.php";

if (CONFIG_REQUIRE_AUTHENTICATION)
	include CONFIG_COMMON_PATH."includes/auth.php";
if (CONFIG_HOOYA_PATH) {
	include CONFIG_HOOYA_PATH."includes/config.php";
	include CONFIG_HOOYA_PATH."includes/users.php";
	include CONFIG_HOOYA_PATH."includes/render.php";
}

if (isset($_FILES['picture']))
if ($_GET['id'] == $_SESSION['userid']) {
	$imageFileType = pathinfo(basename($_FILES['picture']['name']),PATHINFO_EXTENSION);
	$targetfile = 'users/' . $_SESSION['username'] . '-' . basename($_FILES['picture']['name']);
	if (!getimagesize($_FILES['picture']['tmp_name'])) {
		print 'Not an image!'; die;
	}
	if (!move_uploaded_file($_FILES['picture']['tmp_name'], $targetfile)) {
		print 'Someting happened!'; die;
	}
	update_userpicture($_SESSION['userid'], $targetfile);
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
<div id="rightframe" class=userpage>
<?php
	if (isset($_GET['id'])) {
		$id = (int)$_GET['id'];
		render_userpage($id);

	} else {
		print'<h1>Friends</h1><main>';
		foreach (get_users() as $id => $info) {
			if (!$info['picture'])
				$info['picture'] = 'users/vsauce-michael.jpg';
			$userpicture = CONFIG_COMMON_WEBPATH
			. "home/" . $info['picture'];
			$username = $info['username'];
			render_usersummary($id, $username, $userpicture);
		}
		print '</main>'
		. '</div>';
	}
?>
</div>
</div>
<script>
document.getElementById("fupload").onchange = function() {
	this.parentNode.submit();
};
</script>
<?php if (isset($_FILES['picture']))
	print '<script>window.history.back();</script>';
?>
</body>
</HTML>
