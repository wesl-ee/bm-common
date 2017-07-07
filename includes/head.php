<?php
$_SESSION['last_activity'] = new DateTime();
if (!isset($_SESSION['pref_css']))
	reloadUserStyle();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="robots" content="noindex">
<link rel="stylesheet" href=<?php echo CONFIG_COMMON_WEBPATH."css/style_suckless.css"?>>
<link rel="stylesheet" href=<?php echo $_SESSION['stylesheet']?>>
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
