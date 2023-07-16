<?php

class UserController extends View{

    public function index(){
        if(isset($_SESSION['user'])){
            $user = new User('', '', '');
            $res = $user->getById();
            $data['users'] = $res;
            $this->view('user/index', $data);
        }
        else{
            redirect('user/login');
        }
    }

    public function login(){
        if(empty($_SESSION['user'])){
            $this->view('auth/login');
        }
    }

    public function register(){
        if(empty($_SESSION['user'])){
            $this->view('auth/register');
        }
    }

    public function postRegister(){
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = new User($email, $name, $password);
            $res = $user->register();
//            var_dump($res);
            if($res){
                redirect('user/login');
            }
            else{
//                redirect('user/register');
                $_SESSION['errRe'] = 'email đã tồn tại!';
//                $data['success'] = 'email đã tồn tại!';
//                redirect('user/register');
                $this->view('auth/register');
            }
        }
    }

    public function postLogin(){
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = new User($email, '', $password);
            $res = $user->login();
            if($res){
                $_SESSION['user'] = $_POST;
                $_SESSION['user_name'] = $user->name;
                redirect('home/index');
            }
            else{
                $data['err'] = 'email hoặc mật khẩu không đúng';
                $this->view('auth/login', $data);
            }
        }
    }

    public function logout(){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            redirect('user/login');
        }
    }
}