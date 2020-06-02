<?php
//Edit these values :
$dbName="myformv2";
$User_name = "root";
$User_password = "";
/////////Do NoT Change Anything ////////////////
/////////////////Below//////////////
/////////////////////////////////
$pdo = new PDO('mysql:host=localhost;dbname='.$dbName.';charset=utf8', $User_name, $User_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);