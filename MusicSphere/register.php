<html>
<head>
<link REL="StyleSheet" TYPE="text/css" HREF="abc.css">
<meta http-equiv="Cache-Control" content="max-age=200" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Registration Page</title>
</head>
<body>
<?php
include("header.php");
?>
<form name="reg" enctype="multipart/form-data" action="validate.php" method="post">
<fieldset>
<legend><h2>Enter your details</h2></legend>
<table>
<tr><td>Name:</td>
	<td><input type="text" name="name" maxlength="20" /></td></tr>
<tr><td>Last Name:</td>
 	<td><input type="text" name="lastname" maxlength="20" /></td></tr>
<tr><td>Username:</td>
    <td><input type="text" name="username" maxlength="20" /></td></tr>
<tr><td>Password:</td>
	<td><input type="password" name="ps" maxlength="15" /></td></tr>
<tr><td>Gender:</td>
	<td><input type="radio" name="sex" value="male">Male
        <input type="radio" name="sex" value="female">Female</td></tr>
<tr><td>Mobile No:</td>
    <td><input type="text" name="mob" maxlength="10" /></td></tr>
<tr><td>E-mail:</td>
    <td><input type="text" name="email" /></td></tr>
<tr><td>Security Question:</td>
    <td><input type="text" name="security" maxlength="20" /></td></tr>
<tr><td>Answer:</td>
    <td><input type="text" name="answer" maxlength="20" /></td></tr>
</table>
<br /><br />
<input type="submit" value="Submit" />
<input type="reset" value="Reset" />
<br /><br />
<a href="login.php"><u>Goto Login Page</u></a>
</fieldset>
</form>
</body>
</html>