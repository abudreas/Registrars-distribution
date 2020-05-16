<?php

try {
    include __DIR__.'/include/databaseconnection.php';
 include __DIR__.'/class/registrartable.php';
 include __DIR__.'/class/hospitaltable.php';
 include __DIR__.'/class/statetable.php';
;
$hostable = new hospitaltable($pdo);
$sttable = new statetable($pdo);
$regtable = new registrartable($pdo, $hostable, $sttable);
//$sttable->calculate('سنار');
$_POST['id']=19;
$reg = $regtable->findbytele('0123456789',true,true);
echo json_encode($reg,JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}