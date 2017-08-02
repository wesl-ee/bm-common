<!DOCTYPE html>
<?php
include "../includes/core.php";
include CONFIG_COMMON_PATH."includes/accounts.php";
include CONFIG_COMMON_PATH."includes/invites.php";
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bigmike — create an account</title>
</head>
<BODY>

<div id="container">
<div id="leftframe">
	<nav>
		<?php print_login(); ?>
	</nav>
<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
	<header>
		<a href='/'>back</a>
		<h3>account creation wizard</h3>
	</header>
<form action="acc_create.php" method="post">
<?php if (!CONFIG_OPEN_REGISTRATION) {
	print '<label style="display:block;">one-time registration key</label>';
	print '<input style="display:block;" type="password" id="invite_key" name="invite_key" maxlength="128">';
}?>
<label style="display:block;">requested username</label>
<input style="display:block;" type="text" name="username" maxlength="20">
<label style="display:block;">requested password</label>
<input style="display:block;" type="password" name="password" maxlength="50">
<label style="display:block;">confirm password</label>
<input style="display:block;" type="password" name="confirm_password" maxlength="50">
<input style="display:block;" type="submit" value="Sign me up!">
</form>
	<?php if (isset($_POST['username'], $_POST['password']
	, $_POST['confirm_password'])
	&& (CONFIG_OPEN_REGISTRATION || isset($_POST['invite_key']))
	) {
		if ($_POST['confirm_password'] != $_POST['password']) {
			print "Passwords do not match";
			return;
		}
		$username = $_POST['username'];
		$password = $_POST['password'];
		$invite_key = $_POST['invite_key'];
		if (!CONFIG_OPEN_REGISTRATION) {
			$invited_by = invites_validate($invite_key);
			if (!$invited_by) {
				print "Incorrect one-time key!";
				return;
			}
		}
		if (account_create($username, $password, $invited_by) === false) {
			print 'Could not create your account right now. . .';
			return;
		}
		if ($invite_key) invites_invalidate($invite_key);
		print 'Created your account!';
	}?>
</div>
</div>
</body>
</HTML>
