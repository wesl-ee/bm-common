<!DOCTYPE html>
<?php
include "../includes/core.php";
if (isset($_POST['pref_css'])) {
	header("Refresh: 1; url=user_prefs.php");
}
?>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php"; ?>
	<title>bigmike — preferences</title>
</head>
<body>
<div id="container">
<div id="leftframe">
	<nav>
		<?php print_login(); ?>
	</nav>
<img id="mascot" src=<?php print $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
<header>
	<h1>User preferences</h1>
</header>
<main>
<?php
	if (isset($_POST['pref_css'])) {
	$pref_css = $_POST['pref_css'];
	if (!$_POST['mascot']) $workmode = 'on';
		if (updateUserStyle($pref_css, $workmode, $_SESSION['userid'])) {
			print "User style was updated successfully!";
		}
		else {
			print "User style was not updated successfully!";
		}
		die;
	}
	?>
	<form method="post">
	<table style="width:50%;margin:auto;">
	<tr>
		<td>CSS Style</td>
		<td>
		<select id=sel name=pref_css onchange="this.form.submit()">
		<option <?php if ($_SESSION['pref_css']=="bigmike")
			print "selected " ?>
		value="bigmike">Big Mike</option>

		<option <?php if ($_SESSION['pref_css']=="classic")
			print "selected " ?>
		value="classic">Classic</option>

		<option <?php if ($_SESSION['pref_css']=="flylo")
			print "selected " ?>
		value="flylo">Flying Lotus</option>

		<option <?php if ($_SESSION['pref_css']=="hino")
			print "selected " ?>
		value="hino">Hino</option>

		<option <?php if ($_SESSION['pref_css']=="illya")
			print " selected" ?>
		value="illya">Ilya</option>

		<option <?php if ($_SESSION['pref_css']=="gold")
			print "selected " ?>
		value="gold">Gold</option>

		<option <?php if ($_SESSION['pref_css']=="maki")
			print "selected " ?>
		value="maki">Maki</option>

		<option <?php if ($_SESSION['pref_css']=="nier")
			print "selected " ?>
		value="nier">Nier</option>

		<option <?php if ($_SESSION['pref_css']=="red")
			print "selected " ?>
		value="red">Red</option>

		<option <?php if ($_SESSION['pref_css']=="the_room")
			print "selected " ?>
		value="the_room">The Room</option>

		<option <?php if ($_SESSION['pref_css']=="tomie")
			print "selected " ?>
		value="tomie">Tomie</option>

		<option <?php if ($_SESSION['pref_css']=="yys")
			print "selected " ?>
		value="yys">Yuyushiki</option>

		<option <?php if ($_SESSION['pref_css']=="worlds")
			print "selected " ?>
		value="worlds">Worlds</option>

		<option <?php if ($_SESSION['pref_css']=="wu_tang")
			print "selected " ?>
		value="wu_tang">Wu-tang</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Mascot</td>
		<td>
		<input <?php if (!$_SESSION['workmode']) print 'checked'?> type="checkbox" name="mascot" onchange="this.form.submit()"></input>
		</td>
	</tr>
	</table>
	</form>
</main>
</div>
<?php if(isset($_GET['T'])) {
	print '<script>'
	. 'document.getElementById("sel").value="' . $_GET['T'] . '";'
	. 'document.getElementById("sel").form.submit();'
	. '</script>';
}?>
</div>
</body>
</HTML>
