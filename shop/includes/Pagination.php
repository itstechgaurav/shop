<?php

class Pagination
{
    private $allQueryStrings = [];
    private $query = "";
    private $tableName;
    private $total, $limit;

    public function __construct($tableName, $limit = 10)
    {
        $this->tableName = $tableName;
        $this->limit = $limit;
        $this->query = "SELECT count(id) AS total FROM $this->tableName ";
        $this->initQueryString();
    }

    public function custom($qry) {
        $this->query = $qry;
        $this->initQueryString();
    }

    public function condition($con) {
        $this->query .= " $con";
        return $this;
    }

    public function render() {
        $lTotal = mysqli_fetch_object(query($this->query));
        $this->total = $lTotal->total;
        $this->total = ceil($this->total / $this->limit);
        $this->renderUi();
    }

    private function renderUi() {
        echo "<ul class='pagination justify-content-center'>";
        for($i = 1; $i <= $this->total; $i++) {
            $this->updateQueryStrings('page', $i);
            $queryUrl = $this->getQueryString();
            if(!isset($_GET['page'])) $_GET['page'] = 1;
            $is = $i == $_GET['page'] ? 'active' : '';
            echo "<li class='page-item $is'><a class='page-link' href='$queryUrl'>$i</a> </li>";
        }
        echo "</ul>";
    }

    private function initQueryString()
    {
        $lQueryStrings = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : [];
        $lQueryStrings = explode("&", $lQueryStrings);
        foreach ($lQueryStrings As $one) {
            $lOne = explode("=", $one);
            if(isset($one[0]) && isset($one[1])) $this->allQueryStrings[$lOne[0]] = $lOne[1];
        }
    }

    private function updateQueryStrings($key, $value)
    {
        $this->allQueryStrings[$key] = $value;
    }

    private function getQueryString()
    {
        $lStr = "?";
        foreach ($this->allQueryStrings AS $key => $value) {
            $lStr .= "$key=$value";
            if (end($this->allQueryStrings) != $value) $lStr .= "&";
        }
        return $lStr;
    }
}

?>