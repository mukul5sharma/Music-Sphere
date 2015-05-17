<?php
$txt1= ' { "title" : "S" , "chintan" : "test" } ' ;

$json = json_decode($txt1);

echo $json->title;

echo "  ";

echo $json->chintan;

echo "  ";

echo $json->chintan[0];

?>