<!DOCTYPE html>
<?php
include "includes/core.php";
include CONFIG_COMMON_PATH."includes/auth/php";
// If you're not properly authenticated then kick the user back to login.php
if (CONFIG_REQUIRE_AUTHENTICATION)
	include CONFIG_COMMON_PATH."includes/auth.php";
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php"; ?>
	<title>bmffd</title>
</head>
<body>
<div id="container">
<div id="left_frame">
	<div id="logout">
		<?php print_login() ?>
        </div>
	<img id="mascot" src=<?php echo $_SESSION['mascot']?>>
</div>

<div id="right_frame">
	<h1 style="text-align:center;">User Center</h1>
	<div class="header">
	<a href="../">« back</a>
	</div>
	<div style="margin-top:30px;margin-bottom:30px;">
	<div style="float:left;width:50%;text-align:center;padding-bottom:50px;">
		<a href="util/user_prefs.php">User Preferences</a>
	</div>
	<div style="float:left;width:50%;text-align:center;padding-bottom:50px;">
		<a href="util/change_passwd.php">Change password</a>
	</div>
	</div>
	<div style="margin-top:30px;margin-bottom:30px;">
	<div style="float:left;width:100%;text-align:center">
		<a href="util/invite.php">Invite a Friend</a>
	</div>
	</div>
</div>
</div>
</body>
</HTML>
