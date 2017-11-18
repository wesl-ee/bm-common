<?php

// Yes, this site uses sessions! Please enable cookies!
session_start();

// deployment-specific configuration
include("config.php");

//function definitions
// updates the user's current style and stashes that into a SQL table
function updateUserStyle($css, $workmode, $id = NULL)
{
	$_SESSION['workmode'] = $workmode;
	$_SESSION['pref_css'] = $css;

	if (!$workmode) $workmode = 'no';
	if ($id) {
		$dbh = mysqli_connect(CONFIG_DB_SERVER,
			CONFIG_DB_USERNAME,
			CONFIG_DB_PASSWORD,
			CONFIG_DB_DATABASE);
		mysqli_set_charset($dbh, 'utf8');

		$query = "UPDATE `users` SET `pref_css`='$css'"
		. ", `workmode`='$workmode' WHERE `id`='$id'";
		mysqli_query($dbh, $query);
	}
	reloadUserStyle();
	return True;
}
// Set all the elements that define a style
function reloadUserStyle() {
	if (!isset($_SESSION['pref_css'])) $_SESSION['pref_css'] = 'homura';
	switch($_SESSION['pref_css']) {
	case "maki":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_maki.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/maki.png";
		$_SESSION['motd'] = [
			"お帰りなさい",
		];
		break;
	case "gold":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_gold.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/yui.png";
		$_SESSION['motd'] = [
			"おかえりなさい",
		];
		break;
	case "wu_tang":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_wutang.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/ghost.png";
		$_SESSION['motd'] = [
			"Protect ya neck",
			"Wu-tang forever",
			"C.R.E.A.M",
			"Protect the Cuban Linx",
		];
		break;
	case "red":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_red.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/mao.png";
		$_SESSION['motd'] = [
			"为人民服务",
		];
		break;
	case "nier":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_nier.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/2B.png";
		$_SESSION['motd'] = [
			"おかえりなさい",
		];
		break;
	case "bigmike":
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_bigmike.css";
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/mike.png";
		$_SESSION['motd'] = [
			"おかえりなさい",
		];
		break;
	case "yys":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/yuzuko.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_yys.css";
		$_SESSION['motd'] = [
			"よぉ",
		];
		break;
	case "worlds":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/hand.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_worlds.css";
		$_SESSION['motd'] = [
			"We'll see creation come undone",
			"私は",
			"Is anyone there",
			"We'll be the lionhearted",
		];
		break;
	case "hino":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/hinobaby.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_hino.css";
		$_SESSION['motd'] = [
			"おかえりなさい",
		];
		break;
	case "illya":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/illya.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_illya.css";
		$_SESSION['motd'] = [
			"おかえりなさい",
		];
		break;
	case "flylo":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/flylo.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_flylo.css";
		$_SESSION['motd'] = [
			"おかえりなさい",
		];
		break;
	case "the_room":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/tommy.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_the_room.css";
		$_SESSION['motd'] = [
			"You're tearing me apart",
			"Hahaha what a story",
			"So how's your sex life",
			"Oh hi",
		];
		break;
	case "classic":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/classic.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_classic.css";
		$_SESSION['motd'] = [
			"Welcome to the server"
		];
		break;
	case "tomie":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/tomie.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_tomie.css";
		$_SESSION['motd'] = [
			"Love me to death"
		];
		break;
	case "20XX":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/20XX.gif";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_20XX.css";
		$_SESSION['motd'] = [
			"Welcome to 20XX"
		];
		break;
	case "homura":
		$_SESSION['mascot']=CONFIG_COMMON_WEBPATH."img/homura.png";
		$_SESSION['stylesheet']=CONFIG_COMMON_WEBPATH."css/style_suckless_homura.css";
		$_SESSION['motd'] = [
			"Welcome homu"
		];
		break;
	}
	if ($_SESSION['workmode'] == 'on') unset($_SESSION['mascot']);
}
// returns a human-readable file-size
function human_filesize($bytes, $decimals = 2)
{
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}
// Generates a random hex string, mostly for generating a salt
function randomHex($len) {
	$chars = 'abcdef01234567890';
	for ($i = 0; $i < $len; $i++)
		$hex .= $chars[rand(0, strlen($chars) - 1)];
	return $hex;
}
// Prints the cute <nav> information at the top left
function print_login()
{
	print('<a href="'.CONFIG_WEBHOMEPAGE.'">home</a></br>');
	if (isset($_SESSION['userid']))
		print '<a href="'.CONFIG_COMMON_WEBPATH.'logout.php">logout</a><br/>'
		. '<a href="'.CONFIG_COMMON_WEBPATH.'home/?id=' . $_SESSION['userid'] . '">my page</a><br/>';
	else
		print '<a href="'.CONFIG_COMMON_WEBPATH.'login.php?ref='
		.$_SERVER['REQUEST_URI'].'">login</a><br/>';
}
// Resolve a user id to a user name
function get_username($id)
{
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "SELECT `username` FROM users WHERE `id` = $id";
	$result = $conn->query($cmd);
	$row = $result->fetch_assoc();

	return $row['username'];
}
function logged_in()
{
	return !CONFIG_REQUIRE_AUTHENTICATION || isset($_SESSION['userid']);
}
function parse_timestamp($ts)
{
	$ymd = substr($ts, 0, strpos($ts, ' '));
	$ymd = explode('-', $ymd);
	$y = $ymd[0]; $m = $ymd[1]; $d = $ymd[2];
	$m = monthname($m);
	return "$m $d, $y";
}
function monthname($m) {
	return [
	'January',
	'February',
	'March',
	'April',
	'May',
	'June',
	'July',
	'August',
	'September',
	'October',
	'November',
	'December'][$m-1];
}
function update_user_identity($id, $address, $user_agent)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);

	$address = mysqli_real_escape_string($dbh, $address);
	$user_agent = mysqli_real_escape_string($dbh, $user_agent);
	$query = "SELECT id, last_activity FROM `identity` WHERE"
	. " `address` = '$address' AND"
	. " `user_agent` = '$user_agent'"
	. " AND `last_activity` > DATE_SUB(NOW(), INTERVAL 1 HOUR);";
	$res = mysqli_query($dbh, $query);
	$row = mysqli_fetch_assoc($res);
	if($row['id'] == $_SESSION['userid']) return;

	$query = "INSERT INTO `identity` (`id`, `address`, `user_agent`)"
	. " VALUES ('$id', '$address', '$user_agent') ON DUPLICATE KEY"
	. " UPDATE `id` = $id, `last_activity` = NOW()";
	mysqli_query($dbh, $query);
}
function check_user_identity($address)
{
	$dbh = mysqli_connect(CONFIG_DB_SERVER,
		CONFIG_DB_USERNAME,
		CONFIG_DB_PASSWORD,
		CONFIG_DB_DATABASE);
	$address = mysqli_real_escape_string($dbh, $address);
	$query = "SELECT id FROM `identity` WHERE"
	. " `address` = '$address'";
	$res = mysqli_query($dbh, $query);
	$row = mysqli_fetch_assoc($res);
	return ($row['id']);
}
// cute!
function cursor()
{
	print "<span class='blink'>_</span>";
}
?>
