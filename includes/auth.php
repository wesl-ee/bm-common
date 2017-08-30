<?php
// Check if the user is authenticated
if (!isset($_SESSION['userid']) && $_SERVER['REQUEST_URI']) {
	$uri = $_SERVER['REQUEST_URI'];
	$uri = urlencode($uri);
	header("Location: ".CONFIG_COMMON_WEBPATH."login.php?ref=$uri");
	die;
}
?>
