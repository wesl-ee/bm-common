<!DOCTYPE html>
<?php
include "../includes/core.php";
include CONFIG_COMMON_PATH."includes/accounts.php";
include CONFIG_COMMON_PATH."includes/invites.php";
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bmffd — create an account</title>
</head>
<BODY>

<div id="container">
<div id="left_frame">
	<div id="logout">
		<?php
		if (isset($_SESSION['userid'])) {
			print('<a href="'.CONFIG_WEBHOMEPAGE.'">home</a></br>');
			print('<a href="'.CONFIG_COMMON_WEBPATH.'logout.php">logout</a>');
		}
		else {
			print('<a href="'.CONFIG_COMMON_WEBPATH.'login.php?ref='.$_SERVER['REQUEST_URI'].'">login</a>');
		}
		?>
	</div>
<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="right_frame">
<h1 style="text-align:center;">the bath house</h1>
<h3 style="text-align:center;margin-top:-20px;">account creation wizard</h3>
<a href='.'>« back</a>
<form action="acc_create.php" method="post">
<?php if (!CONFIG_OPEN_REGISTRATION) {
	print '<label style="display:block;">one-time registration key</label>';
	print '<input style="display:block;" type="password" id="invite_key" name="invite_key" maxlength="50" />';
}?>
<label style="display:block;">requested username</label>
<input style="display:block;" type="text" id="onsen_username" name="onsen_username" maxlength="20" />
<label style="display:block;">requested password</label>
<input style="display:block;" type="password" id="onsen_passowrd" name="onsen_password" maxlength="50" />
<input style="display:block;" type="submit" value="Sign me up!"/>
</form>
<?php if (isset($_POST['onsen_username']) && isset($_POST['onsen_password']) && (CONFIG_OPEN_REGISTRATION || isset($_POST['invite_key']))) {
	$onsen_username = filter_var($_POST['onsen_username'], FILTER_SANITIZE_STRING);
	$onsen_password = filter_var($_POST['onsen_password'], FILTER_SANITIZE_STRING);
	$invite_key = $_POST['invite_key'];
	if (!CONFIG_OPEN_REGISTRATION) {
		if (!invites_validate($invite_key)) {
			print "Incorrect one-time key!";
			return;
		}
	}
	if (account_create($onsen_username, $onsen_password) === false) {
		print 'Could not create your account right now. . .';
		return;
	}
	if ($invite_key) invites_delete($invite_key);
	print 'Created your account!';
}
?>
</div>
</div>
</body>
</HTML>
