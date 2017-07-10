<?php
namespace Admin\Controller;

class SellerController extends FatherController{

    public function index(){
        header("content-type:text/html;charset=utf-8");
        $list = M('seller')->select();
        $lev = C('seller_lev');
        foreach($list as $k => $v){
            foreach ($lev as $kk => $vv){
                if ($v['sr_lev'] == $kk){
                    $list[$k]['sr_lev'] = $vv;
                }
            }
        }
        $this->assign('list' , $list);
        $this->display();
    }

    public function editUser(){
        $lev = C('seller_lev');
        $id = I('id');
        $info = M('seller')->where('id = ' . $id)->find();
        $this->assign('info' , $info);
        $this->assign('lev' , $lev);
        $this->display();
    }

    public function updateUser(){
        if (IS_POST) {
            $name = I('post.name');
            $phone = I('post.phone');
            $idcard = I('post.idcard');
            $lev = I('post.lev');
            $id = I('post.id');
            if ($name == "") {
                exit(json_encode(array('res' => 0, 'msg' => '用户名不能为空')));
            }
            if ($phone == "") {
                exit(json_encode(array('res' => 0, 'msg' => '手机号码不能为空')));
            }
            if ($idcard == "") {
                exit(json_encode(array('res' => 0, 'msg' => '身份证号码不能为空')));
            }
            if ($lev == "") {
                exit(json_encode(array('res' => 0, 'msg' => '请选择经销商等级')));
            }
            $data = [
                'sr_realname' => $name,
                'sr_lev' => $lev,
                'sr_mobile' => $phone,
                'sr_idcard' => $idcard
            ];

            $res = M('seller')->where('id = ' . $id)->save($data);
            if ($res) {
                exit(json_encode(['res' => 1, 'msg' => '修改成功']));
            } else {
                exit(json_encode(['res' => 0, 'msg' => '修改失败，请重新编辑']));
            }
        }
    }

    public function delUser(){
        if (IS_POST){
            $id = I('post.id');
            $userinfo = M('seller')->where('id = ' . $id)->find();
            $openid = $userinfo['openid'];
            $data['is_bind'] = 2;
            $res = M('seller')->where('id = ' . $id)->save($data);
            if ($res){
                $access_token = getAccessToken();
                $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
                $time = time();
                $time = date("Y年m月d日" , $time);
                $post = '{
                               "touser":"'.$openid.'",
                               "template_id":"RqPQnjsE39Id2XKxo-wWUenkcDLZdPKIjOxzQAqP0oQ",
                               "data":{
                                       "first": {
                                           "value":"尊敬的用户，很抱歉您填写的信息不正确，请重新申请",
                                           "color":"#173177"
                                       },
                                       "keyword1":{
                                           "value":"'.$id.'",
                                           "color":"#173177"
                                       },
                                       "keyword2": {
                                           "value":"'.$time.'",
                                           "color":"#173177"
                                       },
                                       "remark":{
                                           "value":"感谢您的支持，如有疑问，请于客服人员联系。",
                                           "color":"#173177"
                                       }
                               }
                           }';
                $info = request_post($url , $post);
                $r = json_decode($info,true);
                if ($r['errmsg'] == 'ok'){
                    exit(json_encode(array('res' => 1 , 'msg' => '拒绝成功')));
                }

            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '拒绝失败，请重试')));
            }
        }
    }

    public function passUser(){
        if (IS_POST){
            $id = I('post.id');
            $userinfo = M('seller')->where('id = ' . $id)->find();
            $openid = $userinfo['openid'];
            $data['is_bind'] = 1;
            $res = M('seller')->where('id = ' . $id)->save($data);
            if ($res){
                $access_token = getAccessToken();
                $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
                $time = time();
                $time = date("Y年m月d日" , $time);
                $post = '{
                               "touser":"'.$openid.'",
                               "template_id":"RqPQnjsE39Id2XKxo-wWUenkcDLZdPKIjOxzQAqP0oQ",
                               "data":{
                                       "first": {
                                           "value":"尊敬的用户，您已成功绑定会员账号，详情：",
                                           "color":"#173177"
                                       },
                                       "keyword1":{
                                           "value":"'.$id.'",
                                           "color":"#173177"
                                       },
                                       "keyword2": {
                                           "value":"'.$time.'",
                                           "color":"#173177"
                                       },
                                       "remark":{
                                           "value":"感谢您的支持，如有疑问，请于客服人员联系。",
                                           "color":"#173177"
                                       }
                               }
                           }';
                $info = request_post($url , $post);
                $r = json_decode($info,true);
                if ($r['errmsg'] == 'ok'){
                    exit(json_encode(array('res' => 1 , 'msg' => '审核成功')));
                }

            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '审核失败，请重试')));
            }
        }
    }

    public function opinion(){
        $list = M('seller_opinion')->select();
        foreach ($list as $k => $v){
            $userInfo = M('seller')->where('openid = "' . $v['sr_openid'] . '"')->find();
            $list[$k]['mobile'] = $userInfo['sr_mobile'];
        }
        $this->assign('list' , $list);
        $this->display();
    }

    public function remark(){
        if (IS_POST){
            $id = I('post.id');
            $remark = I('post.remark');
            $data = [
                'op_remark' => $remark,
                'op_isdeal' => 1
            ];

            $res = M('seller_opinion')->where('id = ' . $id)->save($data);
            if ($res){
                exit(json_encode(array('res' => 1 , 'msg' => '操作成功')));
            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '操作失败')));
            }
        }
    }


}
?>