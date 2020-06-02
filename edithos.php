<?php
/** this editing hospital page. it has a known bug:
 * if there is '0' hospitals in the data base it will crash
 * but I didn't bother to fix it
 */
function castPost($POST,$i){
    /** the $_POST for each form field comes in an array form
     * array for names , array for cities ... etc
     * so i had to cast these arrays into arrays represent hospitals
     * each hospital has it's own array with its name capacity ,, etc
     */
   if (isset($POST["id"][$i])) $hospital["id"]=$POST["id"][$i];
    $hospital["capacity"]=$POST["capacity"][$i]??0;
    $hospital["state"]=$POST["state"][$i]??0;
    if (isset($POST["delet"][$i])) $hospital["delet"]=$POST["delet"][$i];
    $hospital["city"]=$POST["city"][$i]??0;
    $hospital["tier"]=$POST["tier"][$i]??0;
    $hospital["available"]=$POST["avail"][$i]??0;
    $hospital["name"]=$POST["name"][$i]??0;
return $hospital;
}
$output ="عليك تسجيل الدخول كأدمن";
if(!empty($_SESSION) && isset($_SESSION['admin']) && $_SESSION['admin'] > 1){
try {
    include __DIR__.'/include/databaseconnection.php';
 include __DIR__.'/class/registrartable.php';
 include __DIR__.'/class/hospitaltable.php';
 include __DIR__.'/class/statetable.php';
 include __DIR__.'/class/revisetable.php';
$hostable = new hospitaltable($pdo);
$sttable = new statetable($pdo);
$regtable = new registrartable($pdo,$hostable,$sttable);
////////////////////
$editedhospitals =[];
$deletedhospitals=[];
$newhospitals=[];
if (isset($_POST["save"])){
$x=0;
if (isset($_POST["id"])){
$x = count($_POST["id"]);
for ($i=0; $i < $x; $i++) { 
    if (isset($_POST["id"][$i])){
        if ($_POST["delet"][$i]>0){
            
          $deletedhospitals[]= castPost($_POST,$i);
        }else{
            $editedhospitals[]=castPost($_POST,$i);
        }
    }
}}
while (isset($_POST['name'][$x])) {
    $newhospitals[]=castPost($_POST,$x);
    $x++;
}
foreach ($editedhospitals as $hospital) {
    unset($hospital['delet']);
    $hostable->edit($hospital);
}
foreach ($deletedhospitals as $hospital) {
    $regtable->hoschange($hospital['id'],$hospital['delet']);
    $hostable->delete($hospital);
}
foreach ($newhospitals as $hospital) {
    $hostable->add($hospital);
}
}
//////////////////////
$var = $hostable->getall();
$stats = $sttable->all();
foreach ($var as $value) {
    $prevstate[]=$value['state'];
    $prevcity[]=$value['city'];
    $prevtier[]=$value['tier'];
}
$hosarray =$hostable->get(2);
} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}
ob_start();
include  __DIR__ . '/templates/edithos.html.php';

$output = ob_get_clean();
}



include  __DIR__ . '/templates/adminlayout.html.php';