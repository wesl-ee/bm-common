<!DOCTYPE html>
<?php
include "includes/core.php";
include "includes/accounts.php";

// Was the user refered by some other link?
if (isset($_GET['ref']))
	$uri = "?ref=".urlencode($_GET['ref']);
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php"; ?>
	<title>bm — login</title>
</head>
<body>

<div id="container">
<div id="leftframe">
	<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
	<header>
		<h1>bm</h1>
		<a href="util/acc_create.php">create an account</a>
	</header>
<?php
if (isset($_POST['username'], $_POST['password'])) {
	// Don't login too fast!
	sleep(5);

	print "<p>";
	if ($info = login($_POST['username'], $_POST['password'])) {
		print "Welcome home " . $_SESSION['username']
		. "<br/>"
		. "You last logged in on " . $info['last_login']
		. " from " . $info['last_ip'];
		if ($info['failed_logins'] > 0) {
			print "<br/>"
			. "There were " . $info['failed_logins']
			. " failed logins since you last logged in";
		}
		print "</p>"
		. "<span><a href='";
		if (isset($_GET['ref']))
			print rawurldecode($_GET['ref']);
		else
			print CONFIG_WEBHOMEPAGE;
		print "'>Continue</a></span>";
		die;
	}
	else {
		print "Invalid login attempt!";
	}
	print "</p>";
}
?>

<p>
Please log in ～
</p>
<?php
echo('<form action="login.php'.$uri.'" method="post">');
?>
	<label for="username">Username</label></br>
	<input type="text" name="username" value="" maxlength="20" /></br>
	<label for="password">Password</label></br>
	<input type="password" name="password" maxlength="50" /></br></br>
	<input type="submit" value="Login»" />
</form>
</div>
</div>

</body>
</HTML>
