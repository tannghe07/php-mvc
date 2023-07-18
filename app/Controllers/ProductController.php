<?php

class ProductController extends BaseController {
    public function index(){
        if(is_logged_in()){
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
        if(is_logged_in()){
            $this->view('product/add');
        }
        else{
            redirect('user/login');
        }
    }

    public function store(){
        if(is_logged_in()){
            if(isset($_POST['submit'])){
                $pro = new Product();
                $pro->validate($_POST);
                if(!empty($pro->error)){
                    $data['errors'] = $pro->error;
                    $this->view('product/add', $data);
                }
                else{
                    $res = $pro->insert($_POST);
                    if($res) {
                        redirect("product/index");
                    }
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
        if(is_logged_in()){
            $pro = new Product();
            $res = $pro->delete($id);
            if($res){
                $data['success'] = 'xóa thành công!';
                redirect("product/index");
            }
        }
        else{
            redirect('user/login');
        }
    }

    public function edit($id){
        if(is_logged_in()){
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
        if(is_logged_in()){
            if(isset($_POST['submit'])) {
                $pro = new Product();
                $pro->validate($_POST);
                if(!empty($pro->error)){
                    $data['errors'] = $pro->error;
                    $this->view('product/edit', $data);
                }
                else{
                    $res = $pro->update($_POST, $id);
                    if($res) {
                        redirect("product/index");
                    }
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