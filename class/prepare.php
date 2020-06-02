<?php
class prepare {
    private $regtable;
    private $hostable;
    public function __construct($regtable,$hostable){
        $this->regtable =$regtable;
        $this->hostable=$hostable;
    }
    public function prepare(){
        $hosarray = $this->hostable->getallavailable();
        $regarray = $this->regtable->getall();
        $hosarray = $this->preparehospital($hosarray);
        $allhosarray = $this->hostable->getall();
        $regarray = $this->prepareregistrar($regarray,$allhosarray);
        return ['regarray'=>$regarray,'hosarray'=>$hosarray];
    }
    private function prepareregistrar($regarray,$hosarray){
        //defining a "zero Hospital" , a place holder hospital
        //if non exsited in database
        $zeroHospital = ['id'=>0,'name'=>'(undefined)','capacity'=>0,'state'=>0,'city'=>0,'tier'=>0];
        /////////////
        foreach ($hosarray as $hospital) {
            $newhosarray[$hospital['id']] = $hospital;
        }
        foreach ($regarray as &$registrar) {
            
            //arranging the previous shift into nice array
            $newreg['prev']=[];
            foreach ($registrar['prev'] as $prev) {
               if (isset($newhosarray[$prev])){
                    $newreg['prev'][] = $newhosarray[$prev];
               }else{
                $newreg['prev'][] =$zeroHospital;
               }
            }
                    
                
            
            //doing the same for applications
            $newreg['apps']=[];
            foreach ($registrar['app'] as $app) {
                $newreg['apps'][] = $newhosarray[$app]??$zeroHospital;
            }
                
            
            /*calculating `tier` according to rhe
            registrar previos shifts*/
            $newreg['tier'] = 0;
            foreach ($newreg['prev'] as $hospital) {
               if ($hospital['tier'] == 1){
                $newreg['tier']--;
               }elseif($hospital['tier']==4){
                $newreg['tier']+=0.5;
               }
            }
            //assigning other values
            $newreg['id'] = $registrar['id'];
            $newreg['name'] = $registrar['name'];
            $newreg['resid'] = $registrar['resid'];
            $newreg['city'] = $registrar['city'];
            $newreg['shift'] = $registrar['shift'];
            $newreg['verbosresid'] =$registrar['verbosresid'];
            $newreg['currentapplicans'] = 0;
            $registrar = $newreg;

        }
        return $regarray;

    }
    private function preparehospital($hosarray){
        foreach ($hosarray as &$hospital) {
            $hospital['registrar']=[];
            unset($hospital['available']);
        }
        return $hosarray;
    }
}