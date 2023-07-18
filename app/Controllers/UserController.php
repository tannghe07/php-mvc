<?php

class UserController extends View{

    public function index(){
        if(is_logged_in()){
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
        if(!is_logged_in()){
            $this->view('auth/login');
        }
        else{
            redirect('home/index');
        }
    }

    public function register(){
        $this->view('auth/register');
    }

    public function postRegister(){
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = new User($email, $name, $password);
            $res = $user->register();
            if($res){
                redirect('user/login');
            }
            else{
                $_SESSION['errRe'] = 'email đã tồn tại!';
                $this->view('auth/register');
            }
        }
    }

    public function postLogin(){
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $remember = $_POST['remember'];
            $user = new User($email, '', $password);
            $res = $user->login();
            if($res){
                $row = $user->getById("WHERE email = '$email'")->fetch_row();
                $_SESSION['userr'] = $row;
                if($remember != ''){
                    $expires = time() + (60*60*24*7);
                    $token = "@#tan&%";
                    $token_key = hash('sha256', ('key'.$token));
                    $token_value = hash('sha256', ('Logged_in'.$token));
                    setcookie('userr', $token_key.":".$token_value, $expires);
                    $id = $row[0];
                    $user->updateToken($token_key, $token_value, $id);
                }
//                print_r(is_logged_in());
                redirect('home/index');
            }
            else{
                $data['err'] = 'email hoặc mật khẩu không đúng';
                $this->view('auth/login', $data);
            }
        }
    }

    public function logout(){
        if(!empty($_SESSION['userr'])){
            unset($_SESSION['userr']);
            setcookie('userr', '', time() - (60*60*24*7));
            redirect('user/login');
        }
    }
}