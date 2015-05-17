<?php
ini_set('include_path', 'C:/xampp/php/OdataPHP');
require_once 'C:\xampp\php\OdataPHP\MusicSphereProxies.php'; 

//$proxy = new MusicSphereEntities(); 
//$response = $proxy->Execute("user"); 
//foreach($response->Result as $user) 
//{ 
//    echo $user->fname."- ".$user->lname."</br>"; 
//}

$proxy = new MusicSphereEntities(); 
$response = $proxy->registration()
							->Filter("username eq 'hardik'and password eq 'qwerty1'")
							//->Filter("password eq 'qwerty'")
							//->Expand("user")
							->Execute();
//$reg = $response->Result[1]->user;	
//foreach($response->Result[0]->user as $reg) 
//{ 
//    echo $reg->email."</br>"; 
//}						
$reg = $response->Result[0];
echo $reg->answer;
//echo $reg->user;
//echo $reg->password;
//echo count($reg);

//var_dump($reg);


?>
