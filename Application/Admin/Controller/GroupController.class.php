<?php
namespace Admin\Controller;

class GroupController extends FatherController{

    public function index(){
        $list = M('admin_role')->select();
        foreach ($list as $k=>$v){
            if ($v['parent_id'] == 0){
                $list[$k]['parent_name'] = '顶级';
            }else {
                $parent_name = M('admin_role')->where('role_id = ' . $v['parent_id'])->find();
                $list[$k]['parent_name'] = $parent_name['role_name'];
            }
        }
        $this->assign('list' , $list);
        $this->display();
    }

    public function add(){

        $model = M('admin_role');
        $list = $model->select();
        $this->assign('list' , $list);
        $this->display();
    }

    public function addGroup(){
        if (IS_POST){
            $name = I('post.name');
            $desc = I('post.desc');
            $parent_id = I('post.parent_id');
            if ($name == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '用户组名不能为空')));
            }
            $data = [
                'role_name' => $name,
                'role_desc' => $desc,
                'parent_id' => $parent_id
            ];

            $res = M('admin_role')->data($data)->add();
            if ($res){
                exit(json_encode(array('res' => 1 , 'msg' => '添加成功')));
            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '添加失败，请重新添加')));
            }
        }
    }

    public function delGroup(){
        if (IS_POST){
            $role_id = I('post.role_id');
            $res = M('admin_role')->where('role_id = ' . $role_id)->delete();
            if ($res){
                exit(json_encode(array('res' => 1 , 'msg' => '删除成功')));
            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '删除失败，请重试')));
            }
        }
    }

    public function editGroup(){
        $id = I('role_id');
        $info = M('admin_role')->where('role_id = ' . $id)->find();
        $model = M('admin_role');
        $list = $model->select();

        $this->assign('list' , $list);
        $this->assign('info' , $info);
        $this->display();
    }

    public function updateGroup(){
        if (IS_POST){
            $name = I('post.name');
            $desc = I('post.desc');
            $parent_id = I('post.parent_id');
            $role_id = I('post.role_id');
            if ($name == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '用户组名不能为空')));
            }
            $data = [
                'role_name' => $name,
                'role_desc' => $desc,
                'parent_id' => $parent_id
            ];

            $res = M('admin_role')->where('role_id = ' . $role_id)->save($data);
            if ($res){
                exit(json_encode(array('res' => 1 , 'msg' => '修改成功')));
            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '修改失败，请重新修改')));
            }
        }
    }

}
?>