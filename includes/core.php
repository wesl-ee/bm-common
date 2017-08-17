<?php

// Yes, this site uses sessions! Please enable cookies!
session_start();

// deployment-specific configuration
include("config.php");

//function definitions

// updates the user's current style and stashes that into a SQL table
function updateUserStyle($css = NULL, $id = NULL)
{

	if ($id) {
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	if ($conn->connect_error) {
		return False;
	}
	$cmd = "UPDATE `users` SET `pref_css`='$css' WHERE `id`='$id'";
	$conn->query($cmd);
	}
	$_SESSION['pref_css'] = $css;
	reloadUserStyle();
	return True;
}
function reloadUserStyle() {
	if (!isset($_SESSION['pref_css']))
		$_SESSION['pref_css'] = 'classic';
	switch($_SESSION['pref_css']) {
	case "classic":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_classic.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/maki.png";
		$_SESSION['motd']="お帰りなさい";
		break;
	case "gold":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_gold.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/yui.png";
		$_SESSION['motd']="おかえりなさい";
		break;
	case "wu_tang":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_wutang.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/ghost.png";
		$_SESSION['motd']="Protect ya neck";
		break;
	case "red":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_red.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/mao.png";
		$_SESSION['motd']="为人民服务";
		break;
	case "nier":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_nier.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/2B.png";
		$_SESSION['motd']="おかえりなさい";
		break;
	case "bigmike":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_bigmike.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/mike.png";
		$_SESSION['motd']="おかえりなさい";
		break;
	case "yys":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/yuzuko.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_yys.css";
		$_SESSION['motd']="よぉ";
		break;
	case "worlds":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/hand.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_worlds.css";
		$_SESSION['motd']="we'll see creation come undone";
		break;
	case "hino":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/hinobaby.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_hino.css";
		$_SESSION['motd']="おかえりなさい";
		break;
	}
}
// returns a human-readable file-size
function human_filesize($bytes, $decimals = 2)
{
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}
// used for determining elligibility to be downloaded as a zip file
function isAnAudioFile($filename)
{
	$extension = pathinfo($filename)["extension"];
	if ($extension == "mp3") return true;
	if ($extension == "m4a") return true;
	if ($extension == "flac") return true;
	if ($extension == "aiff") return true;
	if ($extension == "m3u") return true;
	if ($extension == "mpg") return true;
	if ($extension == "wav") return true;
	if ($extension == "ogg") return true;
	if ($extension == "wma") return true;
	return false;
}
// Generates a random hex string, mostly for generating a salt
function randomHex($len) {
	$chars = 'abcdef01234567890';
	for ($i = 0; $i < $len; $i++)
		$hex .= $chars[rand(0, strlen($chars) - 1)];
	return $hex;
}
function randomBase64($len) {
	return base64_encode(random_bytes($len));
}
function print_login()
{
	print '<script>
		var countDownDate = new Date("Aug 16, 2017 09:00:00").getTime();

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
		document.getElementById("timer").innerHTML = days + "d " + hours + "h "
		+ minutes + "m ";

		// If the count down is finished, write some text
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("timer").innerHTML = "<a href=\"http://howler.us.to\">now</a>";
		}
	}, 1000);
	</script>';
	if (isset($_SESSION['userid'])) {
		print('<a href="'.CONFIG_WEBHOMEPAGE.'">home</a></br>');
		print('<a href="'.CONFIG_COMMON_WEBPATH.'logout.php">logout</a><br/>');
	}
	else {
		print('<a href="'.CONFIG_COMMON_WEBPATH.'login.php?ref='.$_SERVER['REQUEST_URI'].'">login</a><br/>');
	}
	print '<a href="http://howler.us.to">howler</a> opens in<div id="timer">&nbsp</div>';
}
function get_username($id)
{
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "SELECT `username` FROM users WHERE `id` = $id";
	$result = $conn->query($cmd);
	$row = $result->fetch_assoc();

	return $row['username'];
}
function cursor()
{
	print "<span class='blink'>_</span>";
}
?>
