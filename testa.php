<?php

try {
    include __DIR__.'/include/databaseconnection.php';
 include __DIR__.'/class/registrartable.php';
 include __DIR__.'/class/hospitaltable.php';
 include __DIR__.'/class/statetable.php';
//$regtable = new registrartable($pdo);
$hostable = new hospitaltable($pdo);
$sttable = new statetable($pdo);
//$sttable->calculate('سنار');
$m = session_status();
if (session_status() == PHP_SESSION_ACTIVE){
    $_SESSION = [];
session_destroy();
}
$m = session_status();
$x=4;
} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}