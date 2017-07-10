<?php
namespace Admin\Controller;

class CompanyController extends FatherController{

    public function index(){
        $parent_role = session('parent_role');
        if ($parent_role == 0){
            $is_top = 1;
        }
        $list = M('admin')->where('admin_id > 1')->select();
        foreach ($list as $k => $v){
            $news_num = M('admin_news')->where('admin_id = ' . $v['admin_id'])->field('count(*) as num')->find();
            $list[$k]['news_num'] = $news_num['num'];
            $group = M('admin_role')->where('role_id = ' . $v['role_id'])->find();
            $list[$k]['group'] = $group['role_name'];
        }
        $this->assign('is_top' , $is_top);
        $this->assign('list' , $list);
        $this->display();
    }

    public function add(){

        $group_list = M('admin_role')->select();
        $this->assign('group_list' , $group_list);
        $this->display();
    }

    public function addUser(){
        if (IS_POST){
            $name = I('post.name');
            $password = I('post.password1');
            $phone = I('post.phone');
            $idcard = I('post.idcard');
            $group = I('post.group');
            if ($name == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '用户名不能为空')));
            }
            if ($password == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '密码不能为空')));
            }
            if ($phone == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '手机号码不能为空')));
            }
            if ($idcard == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '身份证号码不能为空')));
            }
            if ($group == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '请选择所属用户组')));
            }
            $add_time = time();
            $admin_pic = "head_icon/logoo.png";
            $data = [
                'username' => $name,
                'password' => md5($password),
                'add_time' => $add_time,
                'role_id' => $group,
                'mobile' => $phone,
                'idcard' => $idcard,
                'admin_pic' => $admin_pic
            ];

            $res = M('admin')->data($data)->add();
            if ($res){
                exit(json_encode(['res' => 1 , 'msg' => '添加成功']));
            }else{
                exit(json_encode(['res' => 0 , 'msg' => '添加失败，请重新添加']));
            }
        }
    }

    public function editUser(){

        $admin_id = I('get.admin_id');
        $info = M('admin')->where('admin_id = ' . $admin_id)->find();
        $group_list = M('admin_role')->select();

        $this->assign('group_list' , $group_list);
        $this->assign('info' , $info);
        $this->display();
    }

    public function updateUser(){
        if (IS_POST) {
            $name = I('post.name');
            $phone = I('post.phone');
            $idcard = I('post.idcard');
            $group = I('post.group');
            $admin_id = I('post.admin_id');
            if ($name == "") {
                exit(json_encode(array('res' => 0, 'msg' => '用户名不能为空')));
            }
            if ($phone == "") {
                exit(json_encode(array('res' => 0, 'msg' => '手机号码不能为空')));
            }
            if ($idcard == "") {
                exit(json_encode(array('res' => 0, 'msg' => '身份证号码不能为空')));
            }
            if ($group == "") {
                exit(json_encode(array('res' => 0, 'msg' => '请选择所属用户组')));
            }
            $data = [
                'username' => $name,
                'role_id' => $group,
                'mobile' => $phone,
                'idcard' => $idcard
            ];
            $res = M('admin')->where('admin_id = ' . $admin_id)->save($data);
            if ($res) {
                exit(json_encode(['res' => 1, 'msg' => '修改成功']));
            } else {
                exit(json_encode(['res' => 0, 'msg' => '修改失败，请重新编辑']));
            }
        }
    }

    public function delUser(){
        if (IS_POST){
            $admin_id = I('post.admin_id');
            $res = M('admin')->where('admin_id = ' . $admin_id)->delete();
            if ($res){
                exit(json_encode(array('res' => 1 , 'msg' => '删除成功')));
            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '删除失败，请重试')));
            }
        }
    }

}
?>