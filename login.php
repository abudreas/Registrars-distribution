<?php

function fetchadmin($pdo, $tele, $password)
{
    $sql = 'SELECT * FROM `admins` WHERE `tele` = :tele';
    $stmnt = $pdo->prepare($sql);
    $stmnt->bindValue(':tele', $tele);
    $stmnt->execute();
    $arr = $stmnt->fetch(PDO::FETCH_ASSOC);
    if (empty($arr) || ! (isset($arr['password']) && $arr['password'] == $password)) {
        return false;
    } else {
        return $arr;
    }
}
$message = '<p>الرجاء إدخال رقم الهاتف و كلمة السر</p>';
if (isset($_GET['action']) && $_GET['action']=='logout'){
    $_SESSION = [];
    if (session_status()==PHP_SESSION_ACTIVE)session_destroy();
    $output = 'تم تسجيل الخروج';
    include __DIR__ . '/templates/adminlayout.html.php';
    exit;
}

if (! isset($_POST['tele']) || ! isset($_POST['password'])) {
    $message = '<p>الرجاء إدخال رقم الهاتف و كلمة السر</p>';
} else {
    try {
        include __DIR__ . '/include/databaseconnection.php';
        include __DIR__.'/class/registrartable.php';
        include __DIR__.'/class/hospitaltable.php';
        include __DIR__.'/class/statetable.php';

        $hostable = new hospitaltable($pdo);
        $sttable = new statetable($pdo);
        $regtable = new registrartable($pdo,$hostable,$sttable);
        if ($arr = fetchadmin($pdo, $_POST['tele'], $_POST['password'])) {
            $_SESSION = [];
            if (session_status()==PHP_SESSION_ACTIVE)session_destroy();
            
            session_start([
                'cookie_lifetime' => 86400,
            ]);
            $_SESSION['admin'] = $arr['tier'];
            $_SESSION['name'] =$arr['name'];
            header("Location:adminhome.php");
        } else if ($regtable->checkpassword($_POST['tele'], $_POST['password'])) {
            $_SESSION = [];
            if (session_status()==PHP_SESSION_ACTIVE)session_destroy();
            
            session_start([
                'cookie_lifetime' => 86400,
            ]);
            $arr = $regtable->findbytele($_POST['tele'],true);
            foreach ($arr as $key => $value) {
                $_SESSION[$key] = $value;
                
            }
            $_SESSION['admin'] = 0;
            header("Location:edit.php?action=edit");
            exit();
        } else {
            $message = '<P>كلمة السر أو رقم الهاتف غير صحيح!</P>';
        }
    } catch (PDOException $e) {
        $title = 'An error has occurred';

        $output = 'DAtabase error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    }
}
ob_start();

include __DIR__ . '/templates/password.html.php';

$output = ob_get_clean();
include __DIR__ . '/templates/layout.html.php';