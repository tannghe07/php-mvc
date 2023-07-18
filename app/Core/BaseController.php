<?php

class BaseController{
    public function view($name, $data=[]){
        if(!empty($data)){
            extract($data);
        }
        $file = VIEWS.$name.'.php';
        if(file_exists($file)){
            require($file);
        }
        else{
            echo "this view not exist";
        }
    }
}