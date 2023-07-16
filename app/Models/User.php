<?php

class User extends Database{
    private $db;
    private $table = 'users';
    private $email;
    public $name;
    private $password;

    public function __construct($email, $name, $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->db = $this->connect();
    }

    public function getById($condition="", $field="*"){
        $sql = "SELECT $field FROM $this->table $condition";
        $result = $this->db->query($sql);
        return $result;
    }

    public function register(){
        $sql = "SELECT * FROM $this->table WHERE email = '$this->email'";
        $res1 = $this->db->query($sql);
        if(mysqli_num_rows($res1)>0){
            return false;
        }
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $query = "INSERT INTO $this->table(name, email, password) VALUES('$this->name', '$this->email', '$this->password')";
        $result = $this->db->query($query);
        return $result;
    }

    public function login(){
        $sql = "SELECT * FROM $this->table WHERE email = '$this->email'";
        $res1 = $this->db->query($sql);
        if(mysqli_num_rows($res1)>0){
            $row = $res1->fetch_row();
            if(password_verify($this->password, $row[3])){
                $this->name = $row[1];
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
}