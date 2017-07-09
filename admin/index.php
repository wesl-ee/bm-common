<!DOCTYPE html>
<?php
include "../includes/core.php";
// Why do you want the admin panel if you can't handle accounts?
if (!CONFIG_REQUIRE_AUTHENTICATION) die;
include CONFIG_COMMON_PATH."includes/auth.php";
include CONFIG_COMMON_PATH."includes/access.php";
// Don't let not-admins in here!
if (!db_isAdmin($_SESSION['userid'])) die;
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php"; ?>
	<title>bmffd — admin</title>
</head>
<body>
<div id="container">
<div id="left_frame">
	<div id="logout">
		<?php print_login(); ?>
        </div>
	<img id="mascot" src=<?php echo $_SESSION['mascot']?>>
</div>

<div id="right_frame">
	<h1 style="text-align:center;">admin hub</h1>
	<div class="header">
	<a href="../">« back</a>
	</div>
	<div style="text-align:center;padding-bottom:30px;">
	<marquee style="display:block;" behavior="slide" direction="right" scrollamount="30">
		<?php echo($_SESSION['motd'].', '.$_SESSION['username'].'!')
		?>
	</marquee>
	</div>
	<div style="margin-bottom:30px;">
	<div style="float:left;width:33%;text-align:center;padding-bottom:50px;">
		<a href="users.php">flame user</a>
	</div>

	<div style="float:left;width:33%;text-align:center;padding-bottom:50px;">
		<?php if (CONFIG_HOOYA_PATH) {
			print '<a href="'
			. CONFIG_HOOYA_WEBPATH.'admin/import.php">'
			. 'import to hooYa!</a>';
		} ?>&nbsp
	</div>
	<div style="float:left;width:33%;text-align:center;padding-bottom:50px;">
		<?php if (CONFIG_HOOYA_PATH) {
			print '<a href="'
			. CONFIG_HOOYA_WEBPATH.'admin/update.php">'
			. 'clean &amp update hooYa!</a>';
		} ?>&nbsp
	</div>
	<div style="float:left;width:33%;text-align:center">&nbsp</div>
	<div style="float:left;width:33%;text-align:center">
		<?php if (CONFIG_HOOYA_PATH) {
			print '<a href="'
			. CONFIG_HOOYA_WEBPATH.'admin/delete.php">'
			. 'delete from hooYa!</a>';
		} ?>&nbsp
	</div>
	<div style="float:left;width:33%;text-align:center">&nbsp</div>
	</div>
</div>
</div>

</body>
</HTML>
