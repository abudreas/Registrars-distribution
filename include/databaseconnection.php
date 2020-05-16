<?php
$dbName="myformv2";
$pdo = new PDO('mysql:host=localhost;dbname='.$dbName.';charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);