<?php
class hospitaltable{
    private $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    private function query($sql, $parameters = []) {
		$query = $this->pdo->prepare($sql);
		$query->execute($parameters);
		return $query;
    }
    public function get($available){
        $sql = 'SELECT `id` , `name`   FROM `hospitaltable` WHERE `available` = ';
        //hospital not available for application:
         $result = [];
          $arr = $this->query($sql.$available)->fetchAll(PDO::FETCH_NUM);
          foreach ($arr as $key) {
            foreach ($key as $key2 => $value) {
              $result[] = $value;
            }
           
          }

         
          
        
          return $arr;
    }
    public function add ($hospial){
        $query = 'INSERT INTO `' . hospitaltable . '` (';

		foreach ($hospial as $key => $value) {
			$query .= '`' . $key . '`,';
		}

		$query = rtrim($query, ',');

		$query .= ') VALUES (';


		foreach ($hospial as $key => $value) {
			$query .= ':' . $key . ',';
		}

		$query = rtrim($query, ',');

		$query .= ')';

		

		$this->query($query, $hospial);
    }
    public function delete($id ) {
		$parameters = [':id' => $id];

		$this->query('DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id', $parameters);
  }
  public function findnamefromid($id){
    if (isset($id)) {
    $sql = 'SELECT `name`   FROM `hospitaltable` WHERE `id` = :id';
    $par['id'] = $id;
    $st = $this->query($sql,$par);
    $arr = $st->fetch(PDO::FETCH_ASSOC);
    return $arr['name'];
  }else {
    return "";
  }
  
}
}