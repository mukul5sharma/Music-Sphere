<?php 
if(isset($_COOKIE['user']))
{
ini_set('include_path', 'C:/xampp/php/OdataPHP');
require_once 'C:\xampp\php\OdataPHP\MusicSphereProxies.php'; 

$string=$_POST['search'];
$filter_string="substringof('".$string."',title) eq true";
$proxy = new MusicSphereEntities(); 
$response = $proxy->song()
							->Filter($filter_string)
							->Execute();

echo '<h2> Search results for query : "'.$string.'"</h2>';

echo '<br/>';
echo '<br/>';
echo '<table border=2 cellpadding=5>';
echo '<tr><th>Song Title </th><th> Play the song </th></tr>';
foreach($response->Result as $song)
{
	echo '<tr>';
	echo '<td>'.$song->title.'</td>';
	echo '<td><audio controls>
			<source src="'.$song->location.'" type="audio/mp3">
			Your browser does not support this audio format.
			</audio></td>';
	echo '</tr>';
}
echo '</table>';
echo '<br/>';
echo '<br/>';
include("footer.php");
}
else
{

	echo "<h3>Login Failed.......!!! </h3>";
	echo "<a href=\"login.php\">Goto Login Page</a>";
}
?> 
