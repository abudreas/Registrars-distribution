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
    public function findbycode(INT $num){
    $num = $this->decode($num);
    $sql = 'SELECT * FROM `statetable` WHERE `id` = '.$num[0];
    $arr = $this->query($sql)->fetch(PDO::FETCH_NUM);
    $state = $arr[1];
    $resid = $arr[$num[1]];
    return [$resid,$state];
    }
    public function all(){
        $sql = 'SELECT * FROM `statetable`';
        $arr = $this->query($sql)->fetchall(PDO::FETCH_NUM);
        //trim $arr from null values
        foreach ($arr as $key1 => $value1) {
            foreach ($value1 as $key => $value) {
                if (!isset($value)) unset($value1[$key]);
            }
            unset($value1[0]);
            //to return the right index
            $arr[$key1] = [];
            foreach ($value1 as $element) {
                $arr[$key1][]=$element;
            }
            
        }
        //
        return $arr;
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