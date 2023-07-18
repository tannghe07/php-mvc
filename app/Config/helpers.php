<?php

function route($url = ''){
    echo ROOT."/".$url;
}

function redirect($url){
    header("Location: ".ROOT."/".$url);
    die;
}

function is_logged_in(){
    if(!empty($_SESSION['userr']) && is_array($_SESSION['userr'])){
        if(!empty($_SESSION['userr'][0])){
            return true;
        }
    }

    $cookie = $_COOKIE['userr'];
    if(isset($cookie)){
        $parts = explode(":", $cookie);
        $token_key = $parts[0];
        $token_values = $parts[1];
        $user = new User('', '', '');
        $row = $user->getById("WHERE token_key = '$token_key'")->fetch_row();
        if($row != ''){
            if($token_values == $row[4]){
                $_SESSION['userr'] = $row;
                return true;
            }
        }
    }
    return false;
}