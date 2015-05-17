<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link REL="StyleSheet" TYPE="text/css" HREF="abc.css">
<meta http-equiv="Cache-Control" content="max-age=200" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Home Page</title>
</head>

<body>
<img src='pics/logo.jpg'></img>
<?php
if(isset($_COOKIE['user']))
{
$uid=$_COOKIE['user'];
?>
<form action="search.php" method="post">
<h2> Welcome!</h2>
<table name="t1" border=0>
<tr><td>Search:</td><td><input type="text" name="search" maxlength="20" size=20/></td>
<td><input type="submit" name="submit" value="Go!"></td></tr><tr>&nbsp;</tr>

<tr><td><a href="recentlyplayed.php"><u>Recently Played</u></a></td></tr>
<tr><td><a href="favorites.php"><u>Favorites</u></a></td></tr>
</table>

</form>
<br><br>
<?php
echo "<a href=logout.php><u>Logout</u></a>";
}
else
{

	echo "<h3>Login Failed.......!!! </h3>";
	echo "<a href=\"login.php\">Goto Login Page</a>";
}
?>
</body>
</html>