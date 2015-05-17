<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/chintan/json.html");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

curl_close($ch);  

$json = json_decode($output);

echo $output;
echo "<br>";
echo "<br>";
echo $json->glossary->title;




______

// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "example.com/abc.php");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);  
Edit: To send parameters

curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( tch, CURLOPT_POSTFIELDS, array('var1=foo', 'var2=bar'));

_____
?>