<?php 
if(isset($_COOKIE['user']))
{
ini_set('include_path', 'C:/xampp/php/OdataPHP');
require_once 'C:\xampp\php\OdataPHP\MusicSphereProxies.php'; 

$uid=$_COOKIE['user'];

$string="id eq ".$uid."";

$proxy = new MusicSphereEntities(); 
$response2 = $proxy->user()
		->Filter($string)
		->Expand("favourites/song")
		->Execute();
echo "<h3><u>Favourites</u></h3>";
echo '<br/>';
echo '<table border=2 cellpadding=5>';
echo '<tr><th>Song Title </th><th>Play </th></tr>';

foreach($response2->Result[0]->favourites as $fav1) 
{ 
	foreach($fav1->song as $song)
	{
	 echo '<tr>';
	 echo '<td>'.$song->title.'</td>';
	 echo '<td><audio controls>';
	 echo '<source src="'.$song->location.'" type="audio/mp3">
	 Your browser does not support this audio format.
			</audio></td>';
	 echo '</tr>';		
	}
}
echo '</table>';
echo '<br><br><br>';
include("footer.php");
}
else
{

	echo "<h3>Login Failed.......!!! </h3>";
	echo "<a href=\"login.php\">Goto Login Page</a>";
}
?> 
