<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller {
    public function index(){
        $this->display();
    }

    public function login(){

        if(session('?admin_id') && session('admin_id')>0){
            exit(json_encode(array('status'=>0,'msg'=>'您已登录')));
        }

        if(IS_POST){
            $condition['username'] = I('post.username');
            $condition['password'] = I('post.password');
            if(!empty($condition['username']) && !empty($condition['password'])){
                $condition['password'] = md5($condition['password']);
                $admin_info = D('admin')->where($condition)->find();

                if(is_array($admin_info)){
                    session('admin_id',$admin_info['admin_id']);
                    $act_list = M('admin_role')->where(array('role_id' => $admin_info['role_id']))->find();
                    session('parent_role' , $act_list['parent_id']);
                    session('act_list',$act_list['act_list']);
                    session('role_name' , $admin_info['role_id']);
                    $last_login_time = M('admin_log')->where("admin_id = ".$admin_info['admin_id']." and log_info = '后台登录'")->order('log_id desc')->limit(1)->getField('log_time');
                    session('last_login_time',$last_login_time);
                    adminLog('后台登录',__ACTION__);
                    $url = session('from_url') ? session('from_url') : U('Admin/Index/index');
                    exit(json_encode(array('status'=>1,'url'=>$url)));
                }else{
                    exit(json_encode(array('status'=>0,'msg'=>'账号密码不正确')));
                }
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'请填写账号密码')));
            }
        }


    }
}
?>