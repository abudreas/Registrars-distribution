<?php

class registrartable
{

    private $pdo;

    private $sttable;

    private $hostable;

    public function __construct(PDO $pdo, HOSPITALTABLE $hostable, STATETABLE $sttable)
    {
        $this->pdo = $pdo;
        $this->sttable = $sttable;
        $this->hostable = $hostable;
    }

    private function query($sql, $parameters = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }

    public function insertnew($registrar)
    {
        if (! empty($this->findbytele($registrar['basic']['tele']))) {
            return false;
        }
        
        $registrar['basic']['password'] = rand(11111, 99999);
      $this->query($this->insertFromArray($registrar['basic'], 'registrartable'),$registrar['basic']);
        $id = $this->findbytele($registrar['basic']['tele'])['id'];
        if (isset($registrar['prev'])){
        $this->insertPrev($registrar['prev'],$id);
        }
        $this->insertApp($registrar['app'],$id);
        return true;
    }

    public function edit($registrar)
    {      
        $query = ' UPDATE `registrartable` SET ';
        foreach ($registrar['basic'] as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }
        $query = trim($query,',');
        $query .= ' WHERE `id` = ' . $registrar['id'];
        $this->query($query, $registrar['basic']);
        //////////////////
        $query = 'SELECT `id` FROM `previousshifts` WHERE `regID` = '.$registrar["id"];
        $arr = $this->query($query)->fetchall(PDO::FETCH_NUM);
        if (!empty($arr)){
        $query = ' UPDATE `previousshifts` SET ';
        foreach ($arr as $key => $value) {
            if (isset($registrar['prev'][$key+1])){
            $sql=$query;
            $sql.='`hospital`= ? WHERE `id` ='.$value[0];
            $this->query($sql,array_slice($registrar['prev'],$key,1));
            }else{
                $sql ='DELETE FROM `previousshifts` WHERE `previousshifts`.`id` ='.$value[0];
                $this->query($sql);
            }
        }
    }elseif (isset($registrar['prev'])) {
        $this->insertPrev($registrar['prev'],$registrar['id']);
    }
        /////////////////////
        //update app
        $query = ' UPDATE `application` SET ';
        for ($i=1; $i < 4; $i++) { 
            $query .= 'app'.$i.'=?,';
        }
        $query .= '`edit date` = now() WHERE `regID` ='.$registrar['id'];
        $this->query($query,array_values($registrar['app']));
        
         
    }

    public function findbytele($tele, $detailed = false,$verbos =false)
    {
        $sql = 'SELECT * FROM `registrartable` WHERE `tele` = :tele';
        $arrtele['tele'] = $tele;
        $arr = $this->query($sql, $arrtele)->fetch(PDO::FETCH_ASSOC);
        if ($detailed && $arr) {
            $arr =  $this->detail($arr);
        } 
        if ($arr && $verbos){
            return $this->verbos($arr);
        }else{
            return $arr;
        }
    }

    public function checkpassword($tele, $password)
    {
        $arr = $this->findbytele($tele);

        if (isset($arr['password']) && $arr['password'] == $password) {
            return true;
        } else {
            return false;
        }
    }

    

    private function detail($registrar)
    {
        $sql = 'SELECT `hospital`, `app1`,`app2`,`app3`,`date`,`edit date` FROM `application` JOIN
        `previousshifts` ON `application`.`regID` = `previousshifts`.`regID` WHERE `application`.`regID`
        ='.$registrar['id'];
        $arr = $this->query($sql)->fetchall(PDO::FETCH_ASSOC);
        $registrar['prev']=[];
        if (!empty($arr)){
        foreach ($arr as $key => $value) {
            $registrar['prev'][$key+1] = $value['hospital'];
        }
    } else {
      $sql = 'SELECT `app1`,`app2`,`app3`,`date`,`edit date` FROM `application` 
        WHERE `application`.`regID` ='.$registrar['id']; 
        $arr = $this->query($sql)->fetchall(PDO::FETCH_ASSOC);
    }
    if(!$arr){
        return false;
    }
        for ($i = 1; $i < 4; $i ++) {
            $registrar['app'][$i] = $arr[0]['app'.$i];
        }
        $registrar['date'] = $arr[0]['date'];
        $registrar['edit date'] = $arr[0]['edit date'];
        return $registrar;
    }
    private function verbos($registrar){
        if (!empty($registrar['prev'])){
            foreach ($registrar['prev'] as &$value) {
                $value = $this->hostable->findnamefromid($value);
            }
        }
        if (!empty($registrar['app'])){
            foreach ($registrar['app'] as &$value2) {
            $value2 = $this->hostable->findnamefromid($value2);
             }
         }
        $registrar['city'] = $this->sttable->findcity($registrar['city']);
        $registrar['resid'] = $this->sttable->findstate($registrar['resid']);
        return $registrar;
    }

    public function getall()
    {
        $sql = 'SELECT * FROM `registrartable`';
        $stmnt = $this->query($sql);
        $arr =$stmnt->fetchall(PDO::FETCH_ASSOC);
        foreach ($arr as &$value) {
            $value = $this->findbytele($value['tele'],true);
            if (!$value){
                unset($value);
            }else{
            $value['verbosresid'] = $this->sttable->findstate($value['resid']).','.$this->sttable->findcity($value['city']);
        }
    }
        return $arr;
    }

    private function insertPrev($prev, $regID)
    {
        $query = 'INSERT INTO `previousshifts` (`regID`,`shiftNumber`,`hospital`)
            VALUES ';
            $arr=[];
        foreach ($prev as $key => $value) {
            $query .= '(?,?,?),';
            $arr = array_merge($arr, array($regID, $key, $value));
        }
        $query = rtrim($query, ',');
        $this->query($query, $arr);
    }
    private function insertApp($app, $regID){
        
        $query = "INSERT INTO `application` (`app1`,`app2`,`app3`,`regID`,`date`) VALUES (?,?,?,".$regID.",now())";
       
        $this->query($query,array_values($app));
    }

    private function insertFromArray($arr, $table)
    {
        $query = 'INSERT INTO `' . $table . '` (';
        foreach ($arr as $key => $value) {
            $query .= '`' . $key . '`,';
        }

        $query = rtrim($query, ',');

        $query .= ') VALUES (';

        foreach ($arr as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ')';
        return $query;
    }
    public function hoschange($from , $to){
        $sql = 'UPDATE `previousshifts` SET `hospital`=? WHERE `hospital`='.$from;
        $arr[]=$to;
        $this->query($sql,$arr);
        
    }
    public function citychange($from , $to){
        $sql = 'UPDATE `registrartable` SET `city`=? WHERE `city`='.$from;
        $this->query($sql,$arr[0]=$to);
    }
    public function statechange($from , $to){
        $sql = 'UPDATE `registrartable` SET `resid`=? WHERE `resid`='.$from;
        $this->query($sql,$arr[0]=$to);
    }
}
