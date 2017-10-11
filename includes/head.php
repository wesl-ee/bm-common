<?php
if (!isset($_SESSION['pref_css']))
	reloadUserStyle();
if (logged_in()) update_user_identity(
	$_SESSION['userid'],
	$_SERVER['HTTP_X_REAL_IP'],
	$_SERVER['HTTP_USER_AGENT']
);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex">
<link rel="stylesheet" href=<?php echo CONFIG_COMMON_WEBPATH."css/style_suckless.css"?>>
<link rel="stylesheet" href=<?php echo $_SESSION['stylesheet']?>>
<link rel="shortcut icon" type="image/x-icon" href=<?php echo CONFIG_COMMON_WEBPATH."img/favicon.ico"?>>
