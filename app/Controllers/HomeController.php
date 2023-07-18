<?php

class HomeController extends BaseController {

    public function index(){
        if(is_logged_in()){
            $this->view('home');
        }
        else{
            redirect('user/login');
        }
    }
}