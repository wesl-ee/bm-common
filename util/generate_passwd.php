<!DOCTYPE html>
<?php include "../includes/core.php"; ?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bm — password debugging</title>
</head>
<BODY>

<div id="container">
<div id="leftframe">
	<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
	<header>
		<h3>generating a SHA512 passwd hash for debugging</h3>
	</header>
	<form action="generate_passwd.php" method="post">
	</br><label>new password</label></br>
	<input type="password" id="onsen_new_password" name="onsen_new_password" maxlength="50" /></br>
	<input type="submit" value="Calculate my hash"/>
	</form>
	<p>
	Please send me the following hash with your username:
	</p>
	<textarea style="width:100%;resize:none;">
	<?php if (isset($_POST['onsen_new_password'])){
		$salt = randomHex(16);
		$hash = $_POST['onsen_new_password'];
		$hash = crypt($hash, '$6$'.$salt.'$');
		$salted_password = $hash;
		echo $salted_password;
	}
	?>
	</textarea>
</div>
</div>
</body>
</HTML>
