<?php
 $myregistrar =[];
$ok = true;

$message = "<p>الرجاء إدخال رغباتك جميع الحقول إجبارية</p>";
function arrayshifts ($reg){
    //reorgnize the previous shifts into array to be easly red by javascript
    $reg['arrshift']=[0,0,0,0,0,0,0];
    $reg['arrapp'] = [0,0,0];
    if (isset($reg['shift1'])){
        $reg['arrshift'][0]=$reg['shift1'];
    }
    if (isset($reg['shift2'])){
        $reg['arrshift'][1]=$reg['shift2'];
    }
    if (isset($reg['shift3'])){
        $reg['arrshift'][2]=$reg['shift3'];
    }
    if (isset($reg['shift4'])){
        $reg['arrshift'][3]=$reg['shift4'];
    }
    if (isset($reg['shift5'])){
        $reg['arrshift'][4]=$reg['shift5'];
    }
    if (isset($reg['shift6'])){
        $reg['arrshift'][5]=$reg['shift6'];
    }
    if (isset($reg['shift7'])){
        $reg['arrshift'][6]=$reg['shift7'];
    }
    if (isset($reg['app1'])){
        $reg['arrapp'][0]=$reg['app1'];
    }
    if (isset($reg['app2'])){
        $reg['arrapp'][1]=$reg['app2'];
    }
    if (isset($reg['app3'])){
        $reg['arrapp'][2]=$reg['app3'];
    }
    return $reg;
}
function castpost($post=[],$myregistrar=[]){
    foreach ($post as $key => $value) {
        $myregistrar[$key] = $value;
    }
   
    return $myregistrar;
}
function showform()
{
    global $message;global $hostable;
    global $output;global $_POST;
    global $_GET;global $regtable;
global $myregistrar;global $sttable;
global $isfound;global $revise;
$availhosps = $hostable->get(1);
$notavailhosps = $hostable->get(0);

$stats = $sttable->all();


if (!empty($_POST)){
$myregistrar = castpost($_POST,$myregistrar);
}
$myregistrar = arrayshifts($myregistrar);
 //quick fix !?
if (!isset($myregistrar['resid'])) $myregistrar['resid']=[0,0];
////
if (isset($myregistrar['tele']) )$revoutput = $revise->get($myregistrar['tele'],true);
ob_start();
    include  __DIR__ . '/templates/edit.html.php';

    $output = ob_get_clean();
}
function showconfirm($myregistrar){
    global $message;
    global $output;
    global $revise;
    
$message = "<p>شكرا لك لقد تم حفظ رغباتك</p>";


$output = $revise->get($myregistrar['tele'],true);
$output = $message.$output;

}
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
if (!isset($_POST['name']) || !isset($_POST['app1']) || !isset($_POST['app2']) || !isset($_POST['app3']) || !isset($_POST['shift']) || !isset($_POST['resid']) || !isset($_POST['tele'])) {
    $ok = false;
    $message = '<p>الرجاء ملء الفورم </p><p>جميع الحقول إجبارية</p>';
} elseif ($_POST['app1'] == $_POST['app2'] || $_POST['app1'] == $_POST['app3'] || $_POST['app3'] == $_POST['app2']) {
    $ok = false;
    $message = '<p>الرجاء إختيار مستشفيات مختلفة</p>';
}elseif(isset($_GET['action'] ) && $_GET['action'] == 'edit' && $regtable->checkpassword($_POST['tele'],$_POST['password'])){
   $_POST['id'] = $_SESSION['id'];
    $regtable->edit($_POST);
}elseif (! $regtable->insertnew($_POST)){
    $ok = false;
    $message = '<p>لقد تم إدخال هذا الرقم من قبل!</p>';
    $isfound = 1;
}
if ($ok) {
    $myregistrar = $regtable->findbytele($_POST['tele'],true);
    if (session_status() == PHP_SESSION_ACTIVE){
        $_SESSION = [];
session_destroy();
}
   showconfirm($myregistrar);
   
}else{
    if (session_status() == PHP_SESSION_ACTIVE && !empty($_SESSION)){
        $myregistrar = castpost($_SESSION,$myregistrar);
        $myregistrar['resid'] = $sttable->findbycode($myregistrar['resid']);
    }
     
    showform();
}
} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}
include  __DIR__ . '/templates/layout.html.php';
