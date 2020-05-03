<?php
if (isset($_GET['tele'])){
try {
    include __DIR__.'/include/databaseconnection.php';
 include __DIR__.'/class/registrartable.php';
 include __DIR__.'/class/hospitaltable.php';
 include __DIR__.'/class/statetable.php';
 include __DIR__.'/class/revisetable.php';
$hostable = new hospitaltable($pdo);
$sttable = new statetable($pdo);
$regtable = new registrartable($pdo,$hostable,$sttable);
$revise = new revisetable($regtable);
if (!$output = $revise->get($_GET['tele'],false)){
    $message = 'عفوا, رقم الهاتف هذا غير موجود';
    
}

} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}
}else{
    $message = "من فضلك أدخل رقم الهاتف";
}
ob_start();
include  __DIR__ . '/templates/revise.html.php';

$output = ob_get_clean();

include  __DIR__ . '/templates/layout.html.php';