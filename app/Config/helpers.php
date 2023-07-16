<?php

function route($url = ''){
    echo ROOT."/".$url;
}

function redirect($url){
    header("Location: ".ROOT."/".$url);
    die;
}