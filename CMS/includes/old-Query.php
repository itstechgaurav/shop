<?php
//include "db.php";
//include "function.php";
class Query
{
    private $tb_name = '', $qry = '';
    private $cQry = '';
    public $col_name = [];
    public $rows = [];
    public $isData = false;
    public function __construct($name, $id = 0)
    {
        $this->tb_name = $name;
        $this->setColumns();
        if($id != 0 && is_numeric($id)) $this->select($id);
    }
    public function setColumns() {
        $this->qry = query("DESCRIBE $this->tb_name");
        $i = 0;
        while($data = mysqli_fetch_object($this->qry)) {
            $this->{$data->Field} = '';
            $this->col_name[$i++] = $data->Field;
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
        $this->parent = $this;
        $is = true;
        while($row = mysqli_fetch_object($data)) {
            $lobj = new Query($this->tb_name);
            $lobj->setdata($row);
            $lobj->parent = $this;
            array_push($this->rows, $lobj);
            if($is) $this->setdata($this->rows[0]);
            $is = false;
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
        $this->qry = $this->deleteQueryBuilder();
        $this->save();
    }
    public function insert() {
        $this->qry = $this->insertQueryBuilder();
        $this->save();
    }
    public function update() {
        $this->qry = $this->updateQueryBuilder();
        $this->save();
    }
    private function insertQueryBuilder() {
        $qry = "INSERT INTO $this->tb_name(";
        for($i = 0; $i < count($this->col_name); $i++) {
            $key = $this->col_name[$i];
            if($key == 'created_at' || $key == 'updated_at') {
                $this->{$key} = $this->getStamp();
            }
            if($key != 'id') {
                $qry .= "$key";
                if($i != count($this->col_name) - 1) $qry .=", ";
                else $qry .= ") VALUES (";
            }
        }
        for($i = 0; $i < count($this->col_name); $i++) {
            $key = $this->col_name[$i];
            if($key != 'id') {
                $dd = $this->{$key};
                $qry .= "'$dd'";
                if($i != count($this->col_name) - 1) $qry .=", ";
                else $qry .= ")";
            }
        }
        return $qry;
    }
    private function updateQueryBuilder() {
        $qry = "UPDATE $this->tb_name SET ";
        for($i = 0; $i < count($this->col_name); $i++) {
            $key = $this->col_name[$i];
            if($key == 'updated_at') {
                $this->{$key} = $this->getStamp();
            }
            if($key != 'created_at' || $key != 'id') {
                $dd = $this->{$key};
                $qry .= "$key = '$dd'";
                if($i != count($this->col_name) - 1) $qry .=", ";
                else $qry .= " WHERE id = '$this->id'";
            }
        }
        return $qry;
    }
    private function deleteQueryBuilder() {
        $id = $this->id;
        $qry = "DELETE FROM $this->tb_name WHERE id = '$id'";
        return $qry;
    }
    private function getStamp() {
        return query("SELECT CURRENT_TIMESTAMP AS ts", function($data) {
            $data = mysqli_fetch_object($data);
            return $data->ts;
        });
    }
    private function save() {
        query($this->qry);
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
        $this->cQry .= $postStr;
        return $this;
    }
    public function get() {
        $lqry = query($this->cQry); // local query
        $data = mysqli_fetch_object($lqry);
        $this->manualColumnUpdate($data);
        $this->setdata($data);
        return $this;
    }
    public function manualColumnUpdate($data) {
        foreach($data as $key=>$value) {
            array_push($this->col_name, $key);
        }
    }
}
?>
