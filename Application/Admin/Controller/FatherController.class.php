<?php
namespace Admin\Controller;

use Think\Controller;

class FatherController extends Controller {

     public function __construct()
     {
         if (!session('?admin_id')){
             $this->redirect('Login/index');
         }
     }
}

?>