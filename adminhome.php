<?php
if(!empty($_SESSION) && isset($_SESSION['admin']) && $_SESSION['admin'] > 0){
    ob_start();
include  __DIR__ . '/templates/adminhome.html.php';

$output = ob_get_clean();

}else{
    $output = "يجب عليك تسجيل الدخول كأدمن أولا!";
}


include  __DIR__ . '/templates/adminlayout.html.php';