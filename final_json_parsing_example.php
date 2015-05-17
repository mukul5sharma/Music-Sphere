<?php

ob_start();
require("json.html");
$out = ob_get_clean();

ob_start();
require("json1.html");
$out1 = ob_get_clean();

echo $out;
echo "<br>";
echo "<br>";
echo $out1;

$json = json_decode($out);
$json1 = json_decode($out1);

echo "<br>";
echo "<br>";
echo $json->glossary->title;
echo "<br>";
echo "<br>";
echo $json1->glossary;

?>