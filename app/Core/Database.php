<?php

class Database{
    public function connect(){
        $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
        return $conn;
    }
}