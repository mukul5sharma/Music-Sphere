<?php

ob_start();
require("json.html");
$out = ob_get_clean();

echo $out

;

?>