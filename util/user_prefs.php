<!DOCTYPE html>
<?php
include "../includes/core.php";
if (isset($_POST['pref_css'])) {
	header("Refresh: 1; url=user_prefs.php");
}
?>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php"; ?>
	<title>bmffd — preferences</title>
</head>
<body>
<div id="container">
<div id="leftframe">
	<nav>
		<?php print_login(); ?>
	</nav>
<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
<header>
	<h1>User preferences</h1>
</header>
<main>
<?php
	if (isset($_POST['pref_css'])) {
	$pref_css = $_POST['pref_css'];
		if (updateUserStyle($pref_css, $_POST['work'], $_SESSION['userid'])) {
			echo "User style was updated successfully!";
		}
		else {
			echo "User style was not updated successfully!";
		}
		die;
	}
	?>
	<form method="post">
	<table style="width:50%;margin:auto;">
	<tr>
		<td>CSS Style</td>
		<td>
		<select name="pref_css" onchange="this.form.submit()">
		<option <?php if ($_SESSION['pref_css']=="bigmike") echo "selected" ?> value="bigmike">Big Mike</option>
		<option <?php if ($_SESSION['pref_css']=="classic") echo "selected" ?> value="classic">Classic</option>
		<option <?php if ($_SESSION['pref_css']=="hino") echo "selected" ?> value="hino">Hino</option>
		<option <?php if ($_SESSION['pref_css']=="illya") echo "selected" ?> value="illya">Illya</option>
		<option <?php if ($_SESSION['pref_css']=="gold") echo "selected" ?> value="gold">Gold</option>
		<option <?php if ($_SESSION['pref_css']=="nier") echo "selected" ?> value="nier">Nier</option>
		<option <?php if ($_SESSION['pref_css']=="red") echo "selected" ?> value="red">Red</option>
		<option <?php if ($_SESSION['pref_css']=="yys") echo "selected" ?> value="yys">Yuyushiki</option>
		<option <?php if ($_SESSION['pref_css']=="worlds") echo "selected" ?> value="worlds">Worlds</option>
		<option <?php if ($_SESSION['pref_css']=="wu_tang") echo "selected" ?> value="wu_tang">Wu-tang</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Mascot</td>
		<td>
		<input <?php if ($_SESSION['mascot']) echo 'checked'?> type="checkbox" name="work" onchange="this.form.submit()"></input>
		</td>
	</tr>
	</table>
	</form>
</main>
</div>

</div>
</body>
</HTML>
