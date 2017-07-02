<!DOCTYPE html>
<?php
include "../includes/core.php";

include CONFIG_COMMON_PATH."includes/auth.php";
include CONFIG_COMMON_PATH."includes/invites.php";
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bmffd — invite a friend</title>
	<script>
		// Set the date we're counting down to
		var nexttime = "<?php echo invites_nexttime();?>";
		if (nexttime != false) {
			var countDownDate = new Date(nexttime).getTime();

			// Update the count down every 1 second
			var x = setInterval(function() {

			// Get todays date and time
			var now = new Date().getTime();

			// Find the distance between now an the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

			// Display the result in the element with id="demo"
			document.getElementById("timer").innerHTML = "Next key available for request in <br/>"
			+ days + "d " + hours + "h " + minutes + "m ";

			// If the count down is finished, write some text
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("timer").innerHTML = "";
			}
			}, 1000);
		}
	</script>
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
<?php
	if (!CONFIG_ALLOW_INVITES) {
		print '<h3 style="text-align:center;margin-top:-20px;">Invites not allowed</h3>';
		print '<a href="'.CONFIG_WEBHOMEPAGE.'">« back</a>';
		return;
	}
?>

<h3 style="text-align:center;margin-top:-20px;">invite key generator</h3>

<a href=<?php echo CONFIG_WEBHOMEPAGE?>>« back</a>
<div id="timer" style="text-align:center;"></div>
<form method="post">
<input type="hidden" name="generate" value="true" />
<input style="display:block;margin:auto;" type="submit" value="Generate my invite key!"/>
</form>
<?php if (isset($_POST['generate'])) {
	if (!CONFIG_ALLOW_INVITES) {
		return;
	}
	if (!invites_cangenerate($_SESSION['userid'])) {
		print '<h3 style="text-align:center";>FAILURE!</h3>';
		print '<div style="text-align:center">Could not generate a key for you</div>';
		return;
	}
	invites_clean();
	$key = invites_generate($_SESSION['userid']);
	if ($key) {
		print '<h3 style="text-align:center";>SUCCESS!</h3>';
		print '<div style="text-align:center">Your key is:</div>';
		print '<div style="word-wrap:break-word;margin:5px;text-align:center;border:inherit;padding:3px;">';
		print $key;
		print '</div>';
		print '<div style="text-align:center;">Send this key to a friend ';
		print 'and have them sign-up <a href="';
		print CONFIG_COMMON_WEBPATH.'util/acc_create.php">here</a></div>';
	}
}
?>
</div>
</div>
</body>
</HTML>
