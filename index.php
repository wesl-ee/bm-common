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
<div id="leftframe">
	<nav>
		<?php print_login() ?>
        </nav>
	<img id="mascot" src=<?php echo $_SESSION['mascot']?>>
</div>

<div id="rightframe">
	<main class="widemenu">
	<header>
		<h1>User Center</h1>
		<a href="../">back</a>
	</header>
	<ul>
		<li><a href="util/user_prefs.php">User Preferences</a></li>
		<li><a href="util/change_passwd.php">Change password</a></li>
		<li><a href="util/invite.php">Invite a Friend</a></li>
		<li><a href="util/acc_delete.php">Delete your account</a></li>
	</ul>
	</main>
</div>
</div>
</body>
</HTML>
