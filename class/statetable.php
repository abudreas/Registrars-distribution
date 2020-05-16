<?php
class statetable {
    private $pdo;
    public function __construct(PDO $pdo){
$this->pdo=$pdo;
    }
    private function query($sql, $parameters = []) {
		$query = $this->pdo->prepare($sql);
		$query->execute($parameters);
		return $query;
    }
    public function calculate($resid)
    {
        $sql ='SELECT * FROM `statetable`' ;
        $stmt = $this->query($sql);
        $arr = $stmt->fetchall(PDO::FETCH_NUM);
        if (empty($arr)){
            return false;
        }else{
            foreach ($arr as $key1=>$value1) {
                foreach ($value1 as $key => $value) {
                    if ($value == $resid){
                        $n1 = $value1[0];
                        $n2 = $key;
                    }
                }
            }
            
            $num = $this->encode($n1,$n2);
            $resid = $this->findbycode($num);
            return $this->encode($n1,$n2);
        }
    }
    public function findcity(INT $cityID){
    
    $sql = 'SELECT `name` FROM `cities` WHERE `id` = '.$cityID;
    $arr = $this->query($sql)->fetch(PDO::FETCH_NUM);
    if (isset($arr[0])){
    return $arr[0];
    } else {
        return 0;
    }
    }
    public function findstate(INT $stateID){
        $sql = 'SELECT `name` FROM `statetable` WHERE `id` = '.$stateID;
        $arr = $this->query($sql)->fetch(PDO::FETCH_NUM);
        
        return $arr[0];
    }
    public function all(){
        $sql = 'SELECT `id` , `name` FROM statetable';
        $arr = $this->query($sql)->fetchall(PDO::FETCH_NUM);
        //trim $arr from null values
        foreach ($arr as $key => $value) {
                $state[$key][]=$value;
                $sql = 'SELECT `id` ,`name`  FROM cities WHERE `stateID`='.$value[0];
                $cities = $this->query($sql)->fetchall(PDO::FETCH_NUM);
                foreach ($cities as $key2 => $value2) {
                    $state[$key][]=$value2;
                }
            
        }
        //
        
         return $state;
    }

    private function encode($n1,$n2){
        
            
        $n1 *=100;
        $n1 = $n1+$n2;
        return $n1;
    }
    private function decode($num){
      $n1 =  intdiv($num, 100);
      
      $n2 =  fmod($num, 100);
      return [$n1,$n2];

    }
}