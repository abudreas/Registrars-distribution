<?php
class revisetable {
   
    private $regtable;
    private $shiftlist =['الكورس',
    'الشفت الأول',
    'الشفت الثاني',
    'الشفت الثالث',
    'الشفت الرابع',
    'الشفت الخامس',
    'الشفت السادس',
    'الشفت السابع'];
public function __construct(REGISTRARTABLE $regtable){
 
    $this->regtable = $regtable;
    
}
public function get($tele,$small){
$myregistrar = $this->regtable->findbytele($tele,true);

if (empty($myregistrar)){
    return false;
}else{
    $myregistrar['shift'] = $this->shiftlist[$myregistrar['shift']];

}


   

ob_start();
include  __DIR__ . '/../templates/revisetable.html.php';

$output = ob_get_clean();

return $output;
}
}