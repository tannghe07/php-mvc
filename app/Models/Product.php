<?php

class Product extends Database {
    private $db;
    public $error;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function insert($data){
        $field = "";
        $values = "";
        $i = 0;
        foreach ($data as $key => $value) {
            if($key != 'submit'){
                $i++;
                if($i==1){
                    $field.=$key;
                    $values.="'$value'";
                } else {
                    $field.=",".$key;
                    $values.=",'$value'";
                }
            }
        }
        $sql = "INSERT INTO products($field) VALUES($values)";
        $result = $this->db->query($sql);
        return $result;
    }

    public function delete($id){
        $sql = "DELETE FROM products WHERE id=$id";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getById($condition="", $field="*"){
        $sql = "SELECT $field FROM products $condition";
        $result = $this->db->query($sql);
        return $result;
    }

    public function update($data, $condition)
    {
        $str = "";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($key != 'submit') {
                $i++;
                if ($i == 1) {
                    $str .= $key . "='$value'";
                } else {
                    $str .= "," . $key . "='$value'";
                }
            }
        }
        $sql = "UPDATE products SET $str $condition";
        $result = $this->db->query($sql);
        return $result;
    }

    public function validate($data){
        $this->error = [];
        if(empty($data['name'])){
            $this->error['name'] = "name is required!";
        }
    }
}