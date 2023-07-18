<?php

class Product extends Database {
    private $db;
    public $error;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function insert($data){
        $sql = "INSERT INTO products(name, price, quantity) VALUES(?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sii", $data['name'], $data['price'], $data['quantity']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete($id){
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getById($condition="", $field="*"){
        $sql = "SELECT $field FROM products $condition";
        $result = $this->db->query($sql);
        return $result;
    }

    public function update($data, $id)
    {
        $sql = "UPDATE products SET name=?, price=?, quantity=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siii", $data['name'], $data['price'], $data['quantity'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function validate($data){
        $this->error = [];
        if(empty($data['name'])){
            $this->error['name'] = "name is required!";
        }
        if(empty($data['price'])){
            $this->error['price'] = "price is required!";
        }
        if(empty($data['quantity'])){
            $this->error['quantity'] = "quantity is required!";
        }
        if(strlen($data['price'])<0 || strlen($data['price'])>1000000){
            $this->error['price'] = "price from 1 -> 1000000";
        }
        if(strlen($data['quantity'])<0 || strlen($data['quantity'])>10000){
            $this->error['quantity'] = "quantity from 1 -> 10000";
        }
    }
}