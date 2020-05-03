<?php
class registrartable {
    private $pdo;
    private $sttable;
    private $hostable;
    public function __construct(PDO $pdo,HOSPITALTABLE $hostable,STATETABLE $sttable){
        $this->pdo = $pdo;
        $this->sttable = $sttable;
        $this->hostable = $hostable;
    }
    private function query($sql, $parameters = []) {
		$query = $this->pdo->prepare($sql);
		$query->execute($parameters);
		return $query;
    }
    public function insertnew($registrar){
        if (! empty( $this->findbytele($registrar['tele']))) {
            return false;
        }
      $registrar = $this->encodestate($registrar);
        $query = 'INSERT INTO `registrartable` (';

		foreach ($registrar as $key => $value) {
			$query .= '`' . $key . '`,';
		}

		

		$query .= '`date` , `password`) VALUES (';


		foreach ($registrar as $key => $value) {
			$query .= ':' . $key . ',';
		}

		

		$query .= 'NOW() ,'.rand(11111,99999).')';
        $this->query($query, $registrar);
        return true;
    }
    public function edit($registrar){
        $registrar = $this->encodestate($registrar);
        //zeroing previous shifts
        for ($i=1; $i < 8 ; $i++) { 
            if (!isset($registrar['shift'.$i])) $registrar['shift'.$i]= null;
        }
$query = ' UPDATE `registrartable` SET ';

		foreach ($registrar as $key => $value) {
			$query .= '`' . $key . '` = :' . $key . ',';
		}

		$query .= '`edit date` = now()';

		$query .= ' WHERE `id` = '.$registrar['id'];		

		$this->query($query, $registrar);
    }
    public function findbytele($tele,$decoded = false) {
        $sql = 'SELECT * FROM `registrartable` WHERE `tele` = :tele';
        $arrtele['tele']=$tele;
       $arr =  $this->query($sql,$arrtele)->fetch(PDO::FETCH_ASSOC);
       
       if ($decoded && $arr){
        return $this->decode($arr);
       }else{
           return $arr;
       }
       
        }
        public function checkpassword($tele,$password){
           $arr= $this->findbytele($tele);
          
           if (isset($arr['password']) && $arr['password'] == $password){
               return true;
           }else{
               return false;
           }
        }
        private function encodestate($registrar){
$registrar['resid'] = $this->sttable->calculate($registrar['resid']);
return $registrar;
        }
        private function decode($registrar){
            for ($i=1; $i < 8 ; $i++) { 
                if (isset($registrar['shift'.$i])) {
                     $registrar['shift'.$i]= $this->hostable->findnamefromid($registrar['shift'.$i]);
                }
            }
            for ($i=1; $i <  4 ; $i++) { 
                $registrar['app'.$i] = $this->hostable->findnamefromid($registrar['app'.$i]);
            }
            $registrar['resid'] = $this->sttable->findbycode($registrar['resid']);
            return $registrar;
        }
}
