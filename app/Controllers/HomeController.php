<?php

class HomeController extends View {

    public function index(){
        if(isset($_SESSION['user'])){
            $this->view('home');
        }
        else{
            redirect('user/login');
        }
    }
}