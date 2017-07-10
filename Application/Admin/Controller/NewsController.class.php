<?php
namespace Admin\Controller;

class NewsController extends FatherController{

    public function index(){
        $seller_lev = C('seller_lev');
        foreach ($seller_lev as $k => $v){
            if ($v == "老板"){
                unset($seller_lev[$k]);
            }
        }
        $this->assign('seller_lev' , $seller_lev);
        $this->display();
    }

    public function addNews(){
        if (IS_POST){
            $parent_id = session('parent_role');
            if ($parent_id == 0){
                $is_top = 1;
            }
            $title = I('post.title');
            $content = I('post.content');
            $seller_group = I('post.sellers');
            if ($title == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '标题不能为空')));
            }
            if ($seller_group == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '请选择要发送的经销商等级')));
            }

            $admin_id = session('admin_id');
            $admin = M('admin')->where('admin_id = '.$admin_id) ->find();
            $admin_name = $admin['username'];
            $role_id = $admin['role_id'];
            $check_lev = M('admin_role')->where('role_id = ' . $role_id)->find()['parent_id'];
            $add_time = time();
            if ($is_top){
                $data= [
                    'admin_id' => $admin_id,
                    'admin_name' => $admin_name,
                    'seller_group' => $seller_group,
                    'add_time' => $add_time,
                    'news_title' => $title,
                    'news_content' => $content,
                    'check_lev' => $check_lev
                ];
            }else{
                $data= [
                    'admin_id' => $admin_id,
                    'admin_name' => $admin_name,
                    'seller_group' => $seller_group,
                    'add_time' => $add_time,
                    'news_title' => $title,
                    'news_content' => $content,
                    'check_lev' => $check_lev,
                    'check_status' => 0
                ];
            }

            $res = M('admin_news')->data($data)->add();
            if ($res){
                if ($is_top == 1){
                    $access_token = getAccessToken();
                    if ($is_top){
                        $boss = M('seller')->where('sr_lev = 5')->select();
                        if (!$boss){
                            exit(json_encode(array('res' => 0 , 'msg' => '发布成功，等待上级审核')));
                        }
                        foreach ($boss as $k => $v){
                            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
                            $time = time();
                            $time = date("Y年m月d日" , $time);
                            $post = '{
                               "touser":"'.$v['openid'].'",
                               "template_id":"IhmAlWozNrVn0HMgPdLSalJvhoLgg002I1i4FqiN4wU",
                               "url" : "tz.hafeisi.cn/Home/index/article/news_id/'.$res.'/openid/'.$v['openid'].'",
                               "data":{
                                       "first": {
                                           "value":"您有一份新的通知等待审核",
                                           "color":"#FF0000"
                                       },
                                       "keyword1":{
                                           "value":"'.$title.'",
                                           "color":"#FF0000"
                                       },
                                       "keyword2": {
                                           "value":"等待审核",
                                           "color":"#FF0000"
                                       },
                                       "keyword3": {
                                           "value":"'.$time.'",
                                           "color":"#FF0000"
                                       },
                                       "remark":{
                                           "value":"请及时查看！",
                                           "color":"#FF0000"
                                       }
                               }
                           }';
                            $info = request_post($url , $post);
                            $r = json_decode($info,true);
                            if ($r['errmsg'] == 'ok'){
                                continue;
                            }
                        }
                    }

                }else{
                    exit(json_encode(array('res' => 1 , 'msg' => '发布成功，等待上级审核')));
                }
                if ($r){
                    adminLog('新增文章',__ACTION__);
                    exit(json_encode(array('res' => 1 , 'msg' => '发布成功，等待上级审核')));
                }else{
                    exit(json_encode(array('res' => 0 , 'msg' => '发布失败，等待上级审核')));
                }

            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '发布失败，请重新发布' )));
            }
        }
    }

    public function newsList(){
        $type = I('get.type');
        $admin_id = session('admin_id');
        $role_id = M('admin')->where('admin_id = ' . $admin_id)->find()['role_id'];
        $parent_role = session('parent_role');
        if ($parent_role == 0){
            $is_top = 1;
        }
        $admin_new = M('admin_news');
        $seller_lev = C('seller_lev');
        if ($type == ''){
            if ($admin_id == 1){
                $list = $admin_new->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }else{
                $list = $admin_new->where('admin_id = ' . $admin_id)->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }
        }elseif ($type == 'noCheck'){
            if ($admin_id == 1){
                $list = $admin_new->where('check_status = 0')->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }else{
                $list = $admin_new->where('check_status = 0 and admin_id = ' . $admin_id)->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }
        }elseif ($type == 'noPass'){
            if ($admin_id == 1){
                $list = $admin_new->where('check_status = 2')->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }else{
                $list = $admin_new->where('check_status = 2 and admin_id = ' . $admin_id )->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }
        }elseif ($type == 'pass'){
            if ($admin_id == 1){
                $list = $admin_new->where('check_status = 1')->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }else{
                $list = $admin_new->where('check_status = 1 and admin_id = ' . $admin_id)->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }
        }elseif ($type == 'needCheck'){
            if ($admin_id == 1){
                $list = $admin_new->where('check_status = 0')->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }else{
                $list = $admin_new->where('check_status = 0 and check_lev = ' . $role_id)->select();
                foreach ($list as $k => $v){
                    $lev = explode(',' , $v['seller_group']);
                    foreach($lev as $kk => $vv){
                        $list[$k]['seller_lev'] .= ",".$seller_lev[$vv];
                    }
                    $list[$k]['seller_lev'] = ltrim($list[$k]['seller_lev'] , ",");
                    if ($list[$k]['issue_time']){
                        $list[$k]['issue_time'] = date('Y-m-d H:i:s' , $list[$k]['issue_time']);
                    }else{
                        $list[$k]['issue_time'] = '未发布';
                    }

                }
            }
        }
        $this->assign('is_top' , $is_top);
        $this->assign('admin_id' , $admin_id);
        $this->assign('type' , $type);
        $this->assign('list' , $list);
        $this->display();
    }

    public function delNews(){
        if (IS_POST){
            $id = I('post.id');
            $data['check_status'] = 2;
            $res = M('admin_news')->where('news_id = ' . $id)->save($data);
            if ($res){
                exit(json_encode(array('res' => 1 , 'msg' => '拒绝成功')));
            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '拒绝失败，请重试')));
            }
        }
    }

    public function passNews(){
        header('Content-type:text/html;charset=utf-8');
        if (IS_POST){
            $id = I('id');
            $parent_role = session('parent_role');
            if ($parent_role == 0){
                $is_top = 1;
            }
            $time = time();
            if ($is_top){
                $data = [
                    'check_lev' => $parent_role
                ];
            }else{
                $data = [
                    'check_lev' => $parent_role
                ];
            }
            $title = M('admin_news')->where('news_id = ' . $id)->find()['news_title'];
            $res = M('admin_news')->where('news_id = ' . $id)->save($data);
            if ($res){
                if ($is_top == 1){
                    $access_token = getAccessToken();
                    if ($is_top){
                        $boss = M('seller')->where('sr_lev = 5')->select();
                        foreach ($boss as $k => $v){
                            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
                            $time = time();
                            $time = date("Y年m月d日" , $time);
                            $post = '{
                               "touser":"'.$v['openid'].'",
                               "template_id":"IhmAlWozNrVn0HMgPdLSalJvhoLgg002I1i4FqiN4wU ",
                               "url" : "tz.hafeisi.cn/Home/index/article/news_id/'.$id.'/openid/'.$v['openid'].'",
                               "data":{
                                       "first": {
                                           "value":"您有一份新的通知等待审核",
                                           "color":"#FF0000"
                                       },
                                       "keyword1":{
                                           "value":"'.$title.'",
                                           "color":"#FF0000"
                                       },
                                       "keyword2": {
                                           "value":"等待审核",
                                           "color":"#FF0000"
                                       },
                                       "keyword3": {
                                           "value":"'.$time.'",
                                           "color":"#FF0000"
                                       },
                                       "remark":{
                                           "value":"请及时查看！",
                                           "color":"#FF0000"
                                       }
                               }
                           }';
                            $info = request_post($url , $post);
                            $r = json_decode($info,true);
                            if ($r['errmsg'] == 'ok'){
                                continue;
                            }
                        }
                    }

                }

                if ($r){
                    adminLog('审核文章',__ACTION__);
                    exit(json_encode(array('res' => 1 , 'msg' => '审核成功')));
                }else{
                    exit(json_encode(array('res' => 0 , 'msg' => '送审失败，请重新审核' )));
                }


            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '审核失败，请重新审核' )));
            }
            }

        }
    public function doSend($touser, $template_id, $url, $data, $topcolor = '#7B68EE')
    {

        /*
         * data=>array(
                'first'=>array('value'=>urlencode("您好,您已购买成功"),'color'=>"#743A3A"),
                'name'=>array('value'=>urlencode("商品信息:微时代电影票"),'color'=>'#EEEEEE'),
                'remark'=>array('value'=>urlencode('永久有效!密码为:1231313'),'color'=>'#FFFFFF'),
            )
         */
        $template = array(
            'touser' => $touser,
            'template_id' => $template_id,
            'url' => $url,
            'topcolor' => $topcolor,
            'data' => $data
        );
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $this->accessToken;
        $dataRes = $this->request_post($url, urldecode($json_template));
        if ($dataRes['errcode'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function detail(){
        header('Content-type:text/html;charset=utf-8');
        $id = I('id');
        if (isset($id)){
            $info = M('admin_news')->where('news_id = ' . $id)->find();
            $lev = C('seller_lev');
            $seller_lev = explode(',' , $info['seller_group']);
            $i = "";
            foreach ($seller_lev as $k => $v){
                $i .= "," . $lev[$v];
            }
            $info['seller_group'] = ltrim( $i ,"," );
            $info['news_content'] = urldecode($info['news_content']);
            $this->assign('info' , $info);
            $this->display();
        }
    }

    public function editNews(){
        header('Content-type:text/html;charset=utf-8');
        $id = I('id');
        if (isset($id)){
            $info = M('admin_news')->where('news_id = ' . $id)->find();
            $lev = C('seller_lev');
            $seller_lev = explode(',' , $info['seller_group']);

            $info['news_content'] = urldecode($info['news_content']);
            $this->assign('seller_lev' , $seller_lev);
            $this->assign('lev' , $lev);
            $this->assign('info' , $info);
            $this->display();
        }
    }

    public function updateNews(){
        if (IS_POST){

            $title = I('post.title');
            $content = I('post.content');
            $seller_group = I('post.sellers');
            $id = I('post.id');
            if ($title == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '标题不能为空')));
            }
            if ($seller_group == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '请选择要发送的经销商等级')));
            }

            $admin_id = session('admin_id');
            $admin_name = M('admin')->where('admin_id = '.$admin_id) ->find()['username'];
            $add_time = time();
            $data= [
                'seller_group' => $seller_group,
                'add_time' => $add_time,
                'news_title' => $title,
                'news_content' => $content
            ];
            $res = M('admin_news')->where('news_id = ' . $id)->save($data);
            if ($res){
                adminLog('修改文章',__ACTION__);
                exit(json_encode(array('res' => 1 , 'msg' => '修改成功')));
            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '修改失败，请重新发布' )));
            }
        }
    }


}
?>