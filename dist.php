<?php
if(!empty($_SESSION) && isset($_SESSION['admin']) && $_SESSION['admin'] > 0){
    try {
        include __DIR__.'/include/databaseconnection.php';
        include __DIR__.'/include/distfunctions.php';
        include __DIR__.'/class/registrartable.php';
        include __DIR__.'/class/hospitaltable.php';
        include __DIR__.'/class/statetable.php';
        include __DIR__.'/class/revisetable.php';
        include __DIR__.'/class/prepare.php';
        $hostable = new hospitaltable($pdo);
        $sttable = new statetable($pdo);
        $regtable = new registrartable($pdo,$hostable,$sttable);
        $prepare = new prepare($regtable,$hostable);
        $arr = $prepare->prepare();
        $regarray = $arr['regarray'];
        $hosarray = $arr['hosarray'];
        $arr = 0;
        
        if (isset($_POST['result'])){
            $query = ' UPDATE `result` SET `save`=:result';
            $stmnt = $pdo->prepare($query);
            $stmnt->bindParam(':result',$_POST['result']);
            
            $stmnt->execute();
            echo "ok";
            exit;
        }else if(isset($_GET['action'])){
            if ($_GET['action'] == 'new'){
                $result = clalculate($regarray,$hosarray);
                $result = json_encode($result,JSON_UNESCAPED_UNICODE);
                ob_start();
                include  __DIR__ . '/templates/distro.html.php';
                
                $output = ob_get_clean();
            }else if($_GET['action'] == 'edit'){
                $query='SELECT `save` FROM `result` WHERE `id` =1';
                $stmnt= $pdo->query($query);
                $arr=$stmnt->fetch(PDO::FETCH_NUM);
                if ($arr){
                    $result = $arr[0];
                    ob_start();
                    include  __DIR__ . '/templates/distro.html.php';
                    
                    $output = ob_get_clean();
                }else{
                    $output="لا يوجد توزيع محفوظ لتعديله !";
                }
                
            }else if($_GET['action']=='publish'){
                $query='SELECT `save` FROM `result` WHERE `id` =1';
                $stmnt= $pdo->query($query);
                $arr=$stmnt->fetch(PDO::FETCH_NUM);
                if ($arr && $arr[0] != ''){
                    $result = $arr[0];
                    $result=json_decode($result,JSON_OBJECT_AS_ARRAY);
                    ob_start();
                    include  __DIR__ . '/templates/distroPublish.html.php';
                    
                    $output = ob_get_clean();
                }else{
                    $output="لا يوجد توزيع محفوظ لنشره !";
                }
            }else if ($_GET['action']=='reset'){
                if (session_status() == PHP_SESSION_ACTIVE && ! empty($_SESSION)&& isset($_SESSION['admin'])
&& $_SESSION['admin'] > 2){
    $query ="TRUNCATE TABLE  `application`;TRUNCATE TABLE  `previousshifts`;TRUNCATE TABLE  `registrartable`;TRUNCATE TABLE  `result`; INSERT INTO `result` set `save` = '' , `publish` = ''";
$pdo->exec($query);
$output = "Reset Done !";
}
            }
        }else{
            ob_start();
            include  __DIR__ . '/templates/distoOptions.html.php';
            
            $output = ob_get_clean();
        }
        
        
    } catch (PDOException $e) {
        $title = 'An error has occurred';
        
        $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
            $e->getFile() . ':' . $e->getLine();
    }
}else{
    $output = "عليك تسجيل الدخول كأدمن لرؤية هذه الصفحة";
}



include  __DIR__ . '/templates/adminlayout.html.php';


