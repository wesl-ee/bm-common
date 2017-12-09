<?php
include "../includes/core.php";

include CONFIG_COMMON_PATH."includes/auth.php";
include CONFIG_COMMON_PATH."includes/invites.php";
?>
<!DOCTYPE html>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bigmike — invite a friend</title>
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
<div id="leftframe">
	<nav>
		<?php print_login(); ?>
	</nav>
<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
<header>
	<h3>invite key generator</h3>
</header>
<main style='text-align:center;'>
<?php
	if (!CONFIG_ALLOW_INVITES) {
		print '<h3>Invites not allowed</h3>';
		return;
	}
	else {
		print 'This button generates a one-time key!<br/>'
		. 'Do not waste'
		. ' it, one is available site-wide only every ' . CONFIG_INVITE_COOLDOWN;
	}
?>
<div id="timer" style="text-align:center;"></div>
<form method="post">
<input type="hidden" name="generate" value="true" />
<input style="display:block;margin:auto;margin-top:15px;" type="submit" value="Generate my invite key!"/>
</form>
<?php if (CONFIG_ALLOW_INVITES && isset($_POST['generate'])) {
	if (!invites_cangenerate($_SESSION['userid'])) {
		print '<h3 style="text-align:center";>FAILURE!</h3>';
		print '<div style="text-align:center">Could not generate a key for you</div>';
		return;
	}
	invites_clean();
	$key = invites_generate($_SESSION['userid']);
	if ($key) {
		print '<h3 style="text-align:center";>SUCCESS!</h3>'
		. '<div style="text-align:center">Your key is:</div>'
		. '<div style="word-wrap:break-word;margin:5px;text-align:center;border:inherit;padding:3px;">'
		. $key
		. '</div>'
		. '<div style="text-align:center;">Send this key to a friend '
		. 'and have them sign-up <a href="'
		. 'acc_create.php">here</a></div>';
	}
}
?>
</main>
</div>
</div>
</body>
</HTML>
