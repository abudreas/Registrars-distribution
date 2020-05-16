<?php
class hospitaltable
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    private function query($sql, $parameters = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }
    public function get($available)
    {
        if ($available == 2) {
            $sql = 'SELECT `id` , `name`   FROM `hospitaltable`';
            $arr = $this->query($sql)->fetchAll(PDO::FETCH_NUM);
        } else {
            $sql = 'SELECT `id` , `name`   FROM `hospitaltable` WHERE `available` = ';
            $result = [];
            //$available is attached to $sql string:
            $arr = $this->query($sql . $available)->fetchAll(PDO::FETCH_NUM);
            foreach ($arr as $key) {
                foreach ($key as $key2 => $value) {
                    $result[] = $value;
                }

            }

        }

        return $arr;
    }
    public function add($hospial)
    {
        $query = 'INSERT INTO `hospitaltable` (';

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
    public function delete($hospital)
    {
        $id = $hospital['id'];
        $parameters = ['id' => $id];

        $this->query('DELETE FROM `hospitaltable` WHERE `id` = :id', $parameters);
    }
    public function findnamefromid($id)
    {
        if (isset($id)) {
            $sql = 'SELECT `name`   FROM `hospitaltable` WHERE `id` = :id';
            $par['id'] = $id;
            $st = $this->query($sql, $par);
            $arr = $st->fetch(PDO::FETCH_ASSOC);
           if ($arr){
            return $arr['name'];
           } else{
            return "";
           }
        } else {
            return "";
        }

    }
    public function getallavailable()
    {
        $sql = 'SELECT * FROM `hospitaltable` WHERE `available` = 1';
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getall()
    {
        $sql = 'SELECT * FROM `hospitaltable`';
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    function edit($hospital){
        $query = ' UPDATE `hospitaltable` SET ';
        foreach ($hospital as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }
        $query = trim($query,',');
        $query .= ' WHERE `id` = ' . $hospital['id'];
        $this->query($query, $hospital);
    }
}
