<!DOCTYPE html>
<?php
include "../includes/core.php";

if (CONFIG_REQUIRE_AUTHENTICATION)
	include CONFIG_COMMON_PATH."includes/auth.php";
?>
<HTML>
<head>
	<?php include CONFIG_COMMON_PATH."includes/head.php";?>
	<title>bmffd — directory</title>
</head>
<BODY>

<div id="container">
<div id="leftframe">
	<nav>
		<?php
		if (isset($_SESSION['userid'])) {
			print('<a href="'.CONFIG_WEBHOMEPAGE.'">home</a></br>');
			print('<a href="'.CONFIG_COMMON_PATH.'logout.php">logout</a>');
		}
		else {
			print('<a href="'.CONFIG_COMMON_PATH.'login.php?ref='.$_SERVER['REQUEST_URI'].'">login</a>');
		}
	        ?>
        </nav>
<img id="mascot" src=<?php echo $_SESSION['mascot'];?>>
</div>
<div id="rightframe">
<h1 style="text-align:center;">phonebook</h1>
<main>
<table>
<tr style="text-align:left;">
	<th>username</th>
	<th>keeper</th>
	<th>tags added</th>
	<th>join date</th>
</tr>
<?php
	$conn = new mysqli(CONFIG_DB_SERVER, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
	$cmd = "SELECT `username`, `signup_date`, `invited_by`, `tags_added`, `pref_css`, `domain` FROM `users` ORDER BY tags_added DESC";
	$result=$conn->query($cmd);
	foreach ($result as $row) {
		print '<tr>'
		. '<td><a href="mailto:'.$row["username"].'@'.$row["domain"].'" >'.$row["username"].'</a></td>'
		. '<td>';
		if (isset($row["invited_by"])) {
			print get_username($row["invited_by"]);
		}
		print '</td>'
		. '<td>'.$row["tags_added"].'</td>'
		. '<td>'.explode(' ', $row["signup_date"])[0].'</td>'
		. '<tr>';
	}
?>
</table>
</main>
</div>
</div>
</body>
</HTML>
