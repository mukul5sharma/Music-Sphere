<?php
setcookie('user',"",time()-60);
header('Location:login.php');
?>