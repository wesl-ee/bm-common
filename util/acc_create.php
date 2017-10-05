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

<?php if (!CONFIG_OPEN_REGISTRATION) {

}?>
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
		print 'Created your account!<br/>'
		. 'Now just <a href="login.php">login</a>';
	} else {
		print '<form action="acc_create.php" method="post">';
		if (!CONFIG_OPEN_REGISTRATION)
			print '<label>one-time registration key</label><br/>'
			. '<input type="password" id="invite_key"'
			. ' name="invite_key" maxlength="128"><br/>';
		print '<label>requested username</label><br/>'
		. '<input type="text" name="username" maxlength="20"><br/>'
		. '<label>requested password</label><br/>'
		. '<input type="password" name="password" maxlength="50"><br/>'
		. '<label>confirm password</label><br/>'
		. '<input type="password" name="confirm_password" maxlength="50"><br/>'
		. '<input type="submit" value="Sign me up!"><br/>'
		. '</form>';
	}?>
</div>
</div>
</body>
</HTML>
