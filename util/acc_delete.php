<!DOCTYPE html>
<?php
include "../includes/core.php";
include CONFIG_COMMON_PATH."includes/accounts.php";
include CONFIG_COMMON_PATH."includes/invites.php";
include CONFIG_COMMON_PATH."includes/auth.php";
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bigmike — delete your account</title>
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
		<a href='.'>back</a>
		<h3>account deletion wizard</h3>
	</header>
<form method="post">
<label>password</label><br/>
<input type="password" name="password" maxlength="50"><br/>
<label>confirm password</label><br/>
<input type="password" name="confirm_password" maxlength="50"><br/>
<input type="submit" value="Trash me captain!"><br/>
</form>
	<?php if (isset($_POST['password'] , $_POST['confirm_password'])) {
		if ($_POST['confirm_password'] != $_POST['password']) {
			print 'passwords do not match';
			return;
		}
		if (user_validate($_SESSION['username'], $_POST['password'])) {
			account_delete($_SESSION['userid']);
			print 'See you, space cowboy';
		}
		else {
			print 'Invalid password';
		}
	}?>
</div>
</div>
</body>
</HTML>
