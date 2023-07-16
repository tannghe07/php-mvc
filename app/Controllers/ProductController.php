<?php

class ProductController extends View {
    public function index(){
        if(isset($_SESSION['user'])){
            $pro = new Product();
            $res = $pro->getById();
            $data['products'] = $res;
            $this->view('product/index', $data);
        }
        else{
            redirect('user/login');
        }
    }

    public function add(){
        if(isset($_SESSION['user'])){
            $this->view('product/add');
        }
        else{
            redirect('user/login');
        }
    }

    public function store(){
        if(isset($_SESSION['user'])){
            if(isset($_POST['submit'])){
//            $name = $_POST['name'];
//            $price = $_POST['price'];
//            $image = $_POST['quantity'];
//            echo $name."-".$price."-".$image;
                $pro = new Product();
                $res = $pro->insert($_POST);
                if($res) {
                    redirect("product/index");
//                $data['success'] = 'thêm mới thành công!';
//                $this->view('product/index', $data);
                }
            }
            else{
                $this->view('product/add');
            }
        }
        else{
            redirect('user/login');
        }
    }

    public function delete($id){
        if(isset($_SESSION['user'])){
            $pro = new Product();
            $res = $pro->delete($id);
            if($res){
                $data['success'] = 'xóa thành công!';
//            $this->view('product/index', $data);
                redirect("product/index");
            }
        }
        else{
            redirect('user/login');
        }
    }

    public function edit($id){
        if(isset($_SESSION['user'])){
            $pro = new Product();
            $res = $pro->getById("WHERE id=$id");
            $data['products'] = $res;
            $this->view('product/edit', $data);
        }
        else{
            redirect('user/login');
        }
    }

    public function update($id){
        if(isset($_SESSION['user'])){
            if(isset($_POST['submit'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $image = $_POST['quantity'];
                echo $name . "-" . $price . "-" . $image;
                $pro = new Product();
                $res = $pro->update($_POST, "WHERE id=$id");
                if($res) {
                    $data['success'] = 'add product successfully!';
//                $this->view('product/index', $data);
                    redirect("product/index");
                }
            }
            else{
                $this->view('product/edit');
            }
        }
        else{
            redirect('user/login');
        }
    }
}