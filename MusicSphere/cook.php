<?php 
ini_set('include_path', 'C:/xampp/php/OdataPHP');
require_once 'C:\xampp\php\OdataPHP\MusicSphereProxies.php'; 
$uname=$_POST['uname'];
$pswd=$_POST['pswd'];
$filter_string="username eq '".$uname."' and password eq '".$pswd."'";

$proxy = new MusicSphereEntities(); 
$response = $proxy->registration()
							->Expand("user")
							->Filter($filter_string)
							->Execute();


if(count($response->Result)<1)
{
Header('Location:homepage.php')	;
}
else
{
	foreach($response->Result[0]->user as $reg) 
	{ 
		setcookie("user",$reg->id);
	}		

Header('Location:homepage.php');
}
?> 
