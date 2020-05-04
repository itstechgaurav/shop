<?php
//include "db.php";
//include "function.php";

class Query
{
    private $tb_name = '', $qry = '', $pStament = '', $pData = array(), $pType='';
    private $cQry = '', $pdo;
    public $col_name = [];
    public $rows = [];
    public $isData = false;
    public function __construct($name, $id = 0)
    {
        $this->tb_name = $name;
        $this->setColumns();
        if($id != 0 && is_numeric($id)) $this->select($id);

        // Setting up PDO

        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        $this->pdo = new PDO($dsn, "root", "", $options);
    }
    public function setColumns() {
        $this->qry = query("DESCRIBE $this->tb_name");
        while($data = mysqli_fetch_object($this->qry)) {
            $this->{$data->Field} = '';
            array_push($this->col_name, $data->Field);
        }
    }
    public function setdata($data = []) {
        $data = new Objecter($data);
        foreach ($this->col_name as $value) {
            if(array_key_exists($value, $data)) $this->{$value} = $data->{$value};
        }
        return $this;
    }
    public function select($id) {
        $this->qry = query("SELECT * FROM $this->tb_name WHERE id = $id");
        $this->setdata(mysqli_fetch_object($this->qry));
    }
    public function selectWhere($options, $op = 'AND') {
        $qry = $this->selectWhereQueryBuilder($options, $op);
        $this->multiRow(query($qry));
    }
    public function multiRow($data) {
        $is = true;
        while($row = mysqli_fetch_object($data)) {
            $lobj = new Query($this->tb_name);
            $lobj->manualColumnUpdate($row);
            $lobj->setdata($row);
            array_push($this->rows, $lobj);
            if($is) {
                $this->manualColumnUpdate($row);
                $this->setdata($row);
                $is = false;
            }
        }
    }
    private function selectWhereQueryBuilder($options, $op) {
        $qry = "SELECT * FROM $this->tb_name WHERE ";
        $is = false;
        foreach ($options as $key=>$value) {
            if($is) $qry .= "$op ";
            $qry .= "$key = '$value' ";
            $is = true;
        }
        return $qry;
    }
    public function delete() {
        $this->deleteQueryBuilder();
        $this->save();
    }
    public function insert() {
        $this->insertQueryBuilder();
        $this->save();
    }
    public function update() {
        $this->updateQueryBuilder();
        $this->save();
    }
    private function insertQueryBuilder() {
        $qry = "INSERT INTO $this->tb_name (";
        $i = 1;
        foreach ($this->col_name as $key) {
            if($key != 'id') {
                $qry .= "$key";
                if(end($this->col_name) != $key) $qry .= ", ";
                else $qry .= ") VALUES (";
            }
        }
        $i = 1;
        foreach ($this->col_name as $value) {
            if($value != 'id') {
                $qry .= ":$value";
                if($value == 'created_at' || $value == 'updated_at') $this->pData[':' . $value] = date('Y-m-d H:i:s');
                else $this->pData[':' . $value] = $this->{$value};
                if(end($this->col_name) != $value) $qry .= ", ";
                else $qry .= ")";
            }
        }
        $this->pStament = $qry;
    }
    private function updateQueryBuilder() {
        $qry = "UPDATE $this->tb_name SET ";
        for($i = 0; $i < count($this->col_name); $i++) {
            $value = $this->col_name[$i];
            $qry .= "$value = :$value";
            if($value == 'updated_at') $this->pData[':' . $value] = date('Y-m-d H:i:s');
            else $this->pData[':' . $value] = $this->{$value};
            if($i != count($this->col_name) - 1) $qry .= ", ";
            else {
                $qry .= " WHERE id = :wid";
                $this->pData[':wid'] = $this->id;
            };
        }
        $this->pStament = $qry;
    }
    private function deleteQueryBuilder() {
        $this->pStament = "DELETE FROM $this->tb_name WHERE id = :id";
        $this->pData[':id'] =  $this->id;
    }
    private function save() {
        $stmt = $this->pdo->prepare($this->pStament);
        $stmt->execute($this->pData);
    }
    public function getLastInsertedId() {
        return $this->pdo->lastInsertId();
    }
    private function getType($str) {
        if(strpos($str, "int")) return 'i';
        else if(strpos($str, "double")) return 'd';
        else if(strpos($str, "blob")) return 'b';
        else return 's';
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return "Ninja";
    }
    public function preSelect($preStr) {
        $this->cQry = "$preStr FROM $this->tb_name ";
        return $this;
    }
    public function postSelect($postStr) {
        $this->cQry .= ' ' .  $postStr;
        return $this;
    }
    public function paginate($limit = 10) {
        $page = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
        if($page < 0 || !is_numeric($page)) redirector("?");
        $page = $page * $limit;
        $this->postSelect("LIMIT $page, $limit");
        return $this;
    }
    public function get() {
        $lqry = query($this->cQry);
        $this->multiRow($lqry);
        return $this;
    }
    public function manualColumnUpdate($data) {
        foreach($data as $key=>$value) {
            if(!in_array($key, $this->col_name)) array_push($this->col_name, $key);
        }
    }
}
?>

<?php

?>