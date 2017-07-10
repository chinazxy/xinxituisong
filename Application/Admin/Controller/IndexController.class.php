<?php
namespace Admin\Controller;

class IndexController extends FatherController  {
    public function index(){
        $role_id = session('role_name');
        $childrenRole = M('admin_role')->where('parent_id = ' . $role_id)->select();
        $children = "";
        foreach($childrenRole as $k => $v){
            $children .= $v['role_name'] . ",";
        }
        $children = rtrim($children , ",");
        $parent_id = session('parent_role');

        $parentRole = M('admin_role')->where('role_id = ' . $parent_id)->find()['role_name'];
        $admin_id = session('admin_id');
        $log = session('last_login_time');
        $userInfo = M('admin')->where('admin_id = ' . $admin_id)->find();
        $admin_news = M('admin_news');
        $newsNum = $admin_news->where('admin_id = ' . $admin_id . ' AND check_status = 1')->field('count(*) as num')->find();
        $noCheck = $admin_news->where('check_status = 0 and admin_id = ' . $admin_id)->field('count(*) as num')->find();
        $noPass = $admin_news->where('check_status = 2 and admin_id = ' . $admin_id)->field('count(*) as num')->find();
        $needCheck = $admin_news->where('check_status = 0 and check_lev = ' . $role_id)->field('count(*) as num')->find();


            $list = M('admin_news')->where('check_status = 1')->order('issue_time desc')->limit(10)->select();
            foreach($list as $k => $v){
                $admin_id = $v['admin_id'];
                $user = M('admin')->where('admin_id = ' . $admin_id )->find();
                $list[$k]['headpic'] = $user['admin_pic'];
                $list[$k]['name'] = $user['username'];
                $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
            }


        $this->assign('list' , $list);
        $this->assign('needCheck' , $needCheck['num']);
        $this->assign('noPass' , $noPass['num']);
        $this->assign('noCheck' , $noCheck['num']);
        $this->assign('newsNum' , $newsNum['num']);
        $this->assign('children' , $children);
        $this->assign('parent_role_name' , $parentRole);
        $this->assign('last_time' , $log);
        $this->assign('add_time' , date("Y-m-d H:s:d" , $userInfo['add_time']));
        $this->assign('userInfo' , $userInfo);

        $this->display();
    }

    //安全退出
    public function logout(){
        session('admin_id' , null);
        session('last_login_time' , null);
        session('role_id' , null);
        session('role_name' , null);
        $this->redirect('Admin/Login/index');
    }


    public function modInfo(){
        $this->display();
    }

    public function moPassword(){

        $this->display();
    }



    public function doModPassword(){
        if (IS_POST){
            $old_password = md5(I('post.old_password'));
            $password = I('post.password');
            $password1 = I('post.password1');
            if ($old_password == "" || $password == "" || $password1 == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '密码不能为空')));
            }
            if ($password1 != $password){
                exit(json_encode(array('res' => 0 , 'msg' => '两次密码不一致')));
            }
            $userId = session('admin_id');
            $userInfo = M('admin')->where('admin_id = ' . $userId)->find();
            if($old_password != $userInfo['password']){
                exit(json_encode(array('res' => 0 , 'msg' => '原密码错误')));
            }else{
                $res = M('admin')->where('admin_id = ' . $userId)->save(array('password' => $password));
                if ($res){
                    exit(json_encode(array('res' => 1 , 'msg' => '修改成功')));
                }else{
                    exit(json_encode(array('res' => 0 , 'msg' => '修改失败')));
                }
            }

        }
    }

    public function upHeadIcon(){
        $admin_id = session('admin_id');
        $img = I('post.img');
        $res = M('admin')->where(array('admin_id' => $admin_id))->save(array('admin_pic' => $img));
        if ($res){
            echo json_encode(array('res' => 1 , 'msg' => '修改成功'));
            return;
        }else{
            echo json_encode(array('res' => 0 , 'msg' => '修改失败'));
        }
    }

    public function profile(){
        $this->display();
    }

    public function admin(){
        $admin = M('admin')->select();
        $admin_log = M('admin_log');
        $admin_role = M('admin_role');
        foreach ($admin as $k => $v){
            $role_name = $admin_role->where(['role_id' => $v['role_id']])->find();
            $admin[$k]['role_name'] = $role_name['role_name'];
            $admin[$k]['role_desc'] = $role_name['role_desc'];
            $last_time = $admin_log->where(['admin_id' => $v['admin_id']])->order('log_time desc')->limit(1)->select();
            $admin[$k]['last_time'] = $last_time[0]['log_time'];
        }
        $this->assign('admin_list' , $admin);
        $this->display();
    }

    public function addAdmin(){
        $role_list = M('admin_role')->select();
        $this->assign('role_list' , $role_list);
        $this->display();
    }

    public function doAddAdmin(){
        if (IS_POST) {
            $username = I('post.username');
            $password = I('post.password');
            $role_id = I('post.role_id');
            if ($username == "") {
                echo json_encode(array('res' => 0 , 'msg' => '用户名不能为空'));
                exit;
            }
            if ($password == "") {
                echo json_encode(array('res' => 0 , 'msg' => '密码不能为空'));
                exit;
            }
            $username = addslashes($username);
            $password = md5($password);
            $add_time = time();

            $data = [
                'user_name' => $username,
                'password' => $password,
                'add_time' => $add_time,
                'role_id' => $role_id
            ];

            $res = M('admin')->data($data)->add();
            if ($res) {
                echo json_encode(array('res' => 1 , 'msg' => '添加成功'));
                exit;
            }else{
                echo json_encode(array('res' => 0 , 'msg' => '添加失败'));
                exit;
            }

        }
    }

    public function menu(){
        $menu_list = M('admin_menu')->where('m_parent_id = 0')->select();
        foreach ($menu_list as $k => $v){
            $m_id = $v['m_id'];
            $kid_list = M('admin_menu')->where('m_parent_id = '.$m_id)->select();
            $menu_list[$k]['kid_list'] = $kid_list;
        }
        $this->assign('menu_list' , $menu_list);
        $this->display();
    }

    public function addMenu(){
        $menu_list = M('admin_menu')->where('m_parent_id = 0 and m_dis = 1')->select();
        foreach ($menu_list as $k => $v){
            $m_id = $v['m_id'];
            $kid_list = M('admin_menu')->where('m_parent_id = '.$m_id.' and m_dis = 1')->select();
            $menu_list[$k]['kid_list'] = $kid_list;
        }

        $this->assign('menu_list' , $menu_list);
        $this->display();
    }

    public function doAddMenu(){
        if (IS_POST){
            $menu_name = I('post.menu_name');
            $controller_name = I('post.controller_name');
            $method_name = I('post.method_name');
            $father_c_name = I('post.father_c_name');
            $is_show = I('post.is_show');

            if ($menu_name == "" || $controller_name == "" || $method_name == ""){
                echo json_encode(array('res' => 0 , 'msg' => '相关参数不能为空'));
                exit;
            }else{
                $data = [
                    'm_name' => $menu_name,
                    'm_controller' => $controller_name,
                    'm_action' => $method_name,
                    'm_parent_id' => $father_c_name,
                    'm_dis' => $is_show
                ];

                $res = M('admin_menu')->data($data)->add();
                if ($res){
                    echo json_encode(array('res' => 1 , 'msg' => '添加成功'));
                    exit;
                }else{
                    echo json_encode(array('res' => 0 , 'msg' => '添加失败'));
                    exit;
                }
            }
        }
    }

    public function delMenu(){
        if (IS_POST){
            $m_id = I('post.m_id');
            $res = M('admin_menu')->where('m_id = ' . $m_id)->delete();
            if ($res){
                echo json_encode(array('res' => 1 , 'msg' => '删除成功'));
                exit;
            }else{
                echo json_encode(array('res' => 0 , 'msg' => '删除失败'));
                exit;
            }
        }
    }

    public function editMenu(){
        $menu_list = M('admin_menu')->where('m_parent_id = 0 and m_dis = 1')->select();
        foreach ($menu_list as $k => $v){
            $m_id = $v['m_id'];
            $kid_list = M('admin_menu')->where('m_parent_id = '.$m_id.' and m_dis = 1')->select();
            $menu_list[$k]['kid_list'] = $kid_list;
        }
        $this->assign('menu_list' , $menu_list);
        $m_id = I('get.m_id');
        $menuInfo = M('admin_menu')->where('m_id = ' . $m_id)->find();
        $this->assign('menuInfo' , $menuInfo);
        $this->display();
    }

    public function updateMenu(){
        if (IS_POST){
            $menu_name = I('post.menu_name');
            $controller_name = I('post.controller_name');
            $method_name = I('post.method_name');
            $father_c_name = I('post.father_c_name');
            $is_show = I('post.is_show');
            $m_id = I('post.m_id');
            $icon = I('post.icon');

            if ($menu_name == "" || $controller_name == "" || $method_name == ""){
                echo json_encode(array('res' => 0 , 'msg' => '相关参数不能为空'));
                exit;
            }else{
                $data = [
                    'm_name' => $menu_name,
                    'm_controller' => $controller_name,
                    'm_action' => $method_name,
                    'm_parent_id' => $father_c_name,
                    'm_dis' => $is_show,
                    'icon' => $icon
                ];
                $res = M('admin_menu')->where('m_id = ' . $m_id)->save($data);
                if ($res){
                    echo json_encode(array('res' => 1 , 'msg' => '修改成功'));
                    exit;
                }else{
                    echo json_encode(array('res' => 0 , 'msg' => '修改失败'));
                    exit;
                }
            }
        }
    }

    public function role(){
        $role_list = M('admin_role')->select();
        $this->assign('role_list' , $role_list);
        $this->display();
    }

    public function addRole(){
        $menu_list = M('admin_menu')->where('m_parent_id = 0')->select();
        foreach ($menu_list as $k => $v){
            $m_id = $v['m_id'];
            $kid_list = M('admin_menu')->where('m_parent_id = '.$m_id)->select();
            $menu_list[$k]['kid_list'] = $kid_list;
        }
        $this->assign('menu_list' , $menu_list);
        $this->display();
    }

    public function delRole(){
        if (IS_POST){
            $role_id = I('post.role_id');
            $res = M('admin_role')->where('role_id = ' . $role_id)->delete();
            if ($res){
                echo json_encode(array('res' => 1 , 'msg' => '删除成功'));
                exit;
            }else{
                echo json_encode(array('res' => 0 , 'msg' => '删除失败'));
                exit;
            }
        }
    }

    public function editRole(){

    }
}