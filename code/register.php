<!DOCTYPE xhtml PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
"http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

Name: 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="name" maxlength="20" /><br /><br />

Last Name: 		&nbsp;&nbsp;
		<input type="text" name="lastname" maxlength="20" /><br /><br />

Username: 		&nbsp;&nbsp;&nbsp;
		<input type="text" name="username" maxlength="20" /><br /><br />

Password: 	&nbsp;&nbsp;&nbsp;
		<input type="password" name="ps" maxlength="15" /><br /><br />

Gender: 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="name" maxlength="20" /><br /><br />

Mobile No:	&nbsp;
		<input type="text" name="mob" maxlength="10" /><br /><br />


E-mail:		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="email" /><br /><br />

Security Question: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="security" maxlength="20" /><br /><br />

Answer: 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="answer" maxlength="20" /><br /><br />



<br /><br />


<input type="submit" value="Submit" />

<input type="reset" value="Reset" />
<br /><br />
<a href="index.php">Goto Login Page</a>
</fieldset>
</form>

</body>
</html>