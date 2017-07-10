<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $appid = C('AppID');
        $appsecret = C('appsecret');
        $uri = "http://tz.hafeisi.cn/Home/Index/oauth";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect ";
        header("Location:" . $url);
    }
    public function index1(){
        if (session('?openid') || isset($_GET['id'])){
            $openid = session('openid');
            $is_bind = M('seller')->field('is_bind')->where('openid = "' . $openid . '"')->find();
            $is_bind = $is_bind['is_bind'];
            if ($is_bind == 1){
                $this->redirect('articleList' , array('openid' => $openid));
            }elseif ($is_bind == 3){
                $this->redirect('waitbind');
            }elseif ($is_bind == 2){
                $this->redirect('failbind' , array('openid' => $openid));
            }
            $id = $_GET['id'];
            $this->assign('id' , $id);
            $this->assign('openid' , $openid);
            $seller_lev = C('seller_lev');
            $this->assign('seller_lev' , $seller_lev);
            $this->display();
        }else{
            header("Localhost:" , U('Home/Index/index'));
        }
    }

    public function oauth(){
        header("content-type:text/html;charset=utf-8");
        $code = $_GET['code'];
        $state = $_GET['state'];
        $appid = C('AppID');
        $appsecret = C('appsecret');
        if (empty($code)) $this->error('授权失败','index');
        $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code';
        $token = json_decode(http($token_url)[1] , true);
        if (isset($token['errcode'])) {
            echo '<h1>错误：</h1>'.$token['errcode'];
            echo '<br/><h2>错误信息：</h2>'.$token['errmsg'];
            exit;
        }
        $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$token['refresh_token'];

        $access_token = json_decode(http($access_token_url)[1] , true);
        if (isset($access_token['errcode'])) {
            echo '<h1>错误：</h1>'.$access_token['errcode'];
            echo '<br/><h2>错误信息：</h2>'.$access_token['errmsg'];
            exit;
        }
        $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token['access_token'].'&openid='.$access_token['openid'].'&lang=zh_CN';

        $user_info = json_decode(http($user_info_url)[1] , true);
        if (isset($user_info['errcode'])) {
            echo '<h1>错误：</h1>'.$user_info['errcode'];
            echo '<br/><h2>错误信息：</h2>'.$user_info['errmsg'];
            exit;
        }

        $openid = $user_info['openid'];
        $nickname = $user_info['nickname'];
        $headimgurl = $user_info['headimgurl'];
        session('openid' , $openid);
        $data = [
            'openid' => $openid,
            'nickname' => $nickname,
            'headimgurl' => $headimgurl
        ];
        $res = M('seller')->where('openid = "' . $openid . '"')->find();
        if (!$res){
            $re = M('seller')->data($data)->add();
            header("Location:" . U('Home/index/index1' , array('id' => $re)));
        }else{
            header("Location:" . U('Home/index/index1'));
        }

    }

    public function bindInfo(){
        if (IS_POST){
            $realname = I('post.realname');
            $mobile = I('post.mobile');
            $idcard = I('post.idcard');
            $lev = I('post.lev');
            $openid = I('post.openid');
            $id = I('post.id');
            if ($realname == "" || $mobile == "" || $idcard == "" || $lev == ""){
                exit(json_encode(array('res' => 0 , 'msg' => '请填写完整的信息')));
            }
            $user = M('seller')->where('openid = "' . $openid . '"')->find();
            if ($user){
                $is_real = M('distributor_info')->where('REAL_NAME = "' . $realname . '" AND PHONE = "' . $mobile . '" AND CERTIFICATE_NO = "' . $idcard . '" AND DELE_FLAG = 1 AND PARENT_AUDIT = 1')->find();
                if ($is_real){
                    $data = [
                        'sr_realname' => $realname,
                        'sr_mobile' => $mobile,
                        'sr_idcard' => $idcard,
                        'sr_lev' => $lev,
                        'is_bind' => 1
                    ];
                }else{
                    $data = [
                        'sr_realname' => $realname,
                        'sr_mobile' => $mobile,
                        'sr_idcard' => $idcard,
                        'sr_lev' => $lev,
                        'is_bind' => 0
                    ];
                }

                $res = M('seller')->where('openid = "' . $openid . '"')->save($data);
                if ($res){
                    if ($data['is_bind'] == 1){
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
                                           "value":"'.$res.'",
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
                                exit(json_encode(array('res' => 1 , 'url' => U('Home/index/bindsuccess'))));
                            }

                    }elseif($data['is_bind'] == 0){
                        exit(json_encode(array('res' => 1 , 'url' => U('Home/index/waitbind'))));
                    }

                }
            }
        }
    }

    public function bindsuccess(){
        $this->display();
    }

    public function waitbind(){
        $this->display();
    }

    public function failbind(){
        $openid = I('openid');
        $data['is_bind'] = 0;
        $res = M('seller')->where('openid = "' . $openid . '"')->save($data);
        $this->display();
    }

    public function article(){
        $openid = I('openid');
        $userInfo = M('seller')->where('openid = "' . $openid . '"')->find();
        $user_lev = $userInfo['sr_lev'];
        $lev = C('seller_lev');
        if ($lev[$user_lev] == '老板'){
            $is_boss = 1;
        }
        $news_id = I('news_id');
        $info = M('admin_news')->where('news_id = ' . $news_id)->find();
        $info['add_time'] = date('Y-m-d' , $info['add_time']);
        $article = urldecode($info['news_content']);


        $this->assign('is_boss' , $is_boss);
        $this->assign('article' , $article);
        $this->assign('info' , $info);
        $this->display();
    }

    public function passArticle(){

    }

    public function refuseArticle(){

    }

    public function articleList(){
        header('Content-type:text/html;charset-utf-8');
        $openid = I('get.openid');
        $userInfo = M('seller')->where('openid = "' . $openid . '"')->find();
        $user_lev = $userInfo['sr_lev'];
        $lev = C('seller_lev');
        if ($lev[$user_lev] == '老板'){
            $is_boss = 1;
        }
        if ($is_boss){
            $list = M('admin_news')->where('check_lev = 0 and check_status = 0')->select();
        }else{
            $list = M('admin_news')->where('find_in_set("'.$user_lev.'" , seller_group) ')->order('add_time desc')->select();
        }
        foreach($list as $k => $v){
            $list[$k]['add_time'] = date('Y-m-d' , $list[$k]['add_time']);
            preg_match_all('/<p (.*?)>(.*?)<\/p>/' , urldecode($list[$k]['news_content']) , $matches);
            $res = "";
            foreach($matches[2] as $kk => $vv){
                $res .= $vv;
            }
            $list[$k]['content'] = mb_substr(strip_tags($res), 0, 20, 'utf-8');
        }
        $this->assign('num' , count($list));
        $this->assign('list' , $list);
        $this->assign('userInfo' , $userInfo);
        $this->assign('is_boss' , $is_boss);
        $this->assign('openid' , $openid);
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

            $time = time();

                $data = [
                    'check_status' => 1,
                    'issue_time' => $time
                ];
            }
            $article = M('admin_news')->where('news_id = ' . $id)->find();
            $title = $article['news_title'];
            $lev = $article['seller_group'];
            $lev = explode("," , $lev);
            $res = M('admin_news')->where('news_id = ' . $id)->save($data);
            if ($res){

                $access_token = getAccessToken();
                $time = time();
                $time = date("Y年m月d日" , $time);
                foreach ($lev as $k => $v){
                    $sellers = M('seller')->where('sr_lev = ' . $v)->select();
                    foreach ($sellers as $k => $vv){
                        $openid = $vv['openid'];
                        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
                        $post = '{
                               "touser":"'.$openid.'",
                               "template_id":"RqPQnjsE39Id2XKxo-wWUenkcDLZdPKIjOxzQAqP0oQ",
                               "url":"http://tz.hafeisi.cn/Home/index/article/news_id/'.$id.'/openid/'.$openid.'",
                               "data":{
                                       "first": {
                                           "value":"您有一份新的通知等待查阅",
                                           "color":"#FF0000"
                                       },
                                       "keyword1":{
                                           "value":"'.$title.'",
                                           "color":"#173177"
                                       },
                                       "keyword2": {
                                           "value":"'.$time.'",
                                           "color":"#173177"
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
                        }else{
                            exit(json_encode(array('res' => 0 , 'msg' => '审核失败，请重新审核' )));
                        }
                    }
                }

                if ($r){
                    exit(json_encode(array('res' => 1 , 'msg' => '审核成功')));
                }else{
                    exit(json_encode(array('res' => 0 , 'msg' => '审核失败，请重新审核' )));
                }

            }else{
                exit(json_encode(array('res' => 0 , 'msg' => '审核失败，请重新审核' )));
            }
        }

    public function checked(){
        header('Content-type:text/html;charset-utf-8');
        $openid = session('openid');
        $userInfo = M('seller')->where('openid = "' . $openid . '"')->find();

        $user_lev = $userInfo['sr_lev'];
        $lev = C('seller_lev');
        if ($lev[$user_lev] == '老板'){
            $is_boss = 1;
        }
        if ($is_boss){
            $list1 = M('admin_news')->where('check_lev = 0 and check_status = 0')->order('add_time desc')->select();
            $list2 = M('admin_news')->where('check_lev = 0 and check_status > 0')->order('add_time desc')->select();
        }else{
            $this->redirect('Index/article' , array('openid' => $openid));
        }
        foreach($list2 as $k => $v){
            $list2[$k]['add_time'] = date('Y-m-d' , $list2[$k]['add_time']);
            preg_match_all('/<p (.*?)>(.*?)<\/p>/' , urldecode($list2[$k]['news_content']) , $matches);
            $res = "";
            foreach($matches[2] as $kk => $vv){
                $res .= $vv;
            }
            $list2[$k]['content'] = mb_substr(strip_tags($res), 0, 20, 'utf-8');
        }

        $this->assign('num' , count($list1));
        $this->assign('list' , $list2);
        $this->assign('userInfo' , $userInfo);
        $this->assign('openid' , $openid);
        $this->display();
    }

    public function issue(){
        header('Content-type:text/html;charset-utf-8');
        $openid = session('openid');
        $userInfo = M('seller')->where('openid = "' . $openid . '"')->find();
        $user_lev = $userInfo['sr_lev'];
        $lev = C('seller_lev');
        if ($lev[$user_lev] == '老板'){
            $is_boss = 1;
        }
        if ($is_boss){
            $list1 = M('admin_news')->where('check_lev = 0 and check_status = 0')->order('add_time desc')->select();
            $list2 = M('admin_news')->where('check_lev = 0 and check_status = 1')->select();
        }else{
            $this->redirect('Index/article' , array('openid' => $openid));
        }
        foreach($list2 as $k => $v){
            $list2[$k]['add_time'] = date('Y-m-d' , $list2[$k]['add_time']);
            preg_match_all('/<p (.*?)>(.*?)<\/p>/' , urldecode($list2[$k]['news_content']) , $matches);
            $res = "";
            foreach($matches[2] as $kk => $vv){
                $res .= $vv;
            }
            $list2[$k]['content'] = mb_substr(strip_tags($res), 0, 20, 'utf-8');
        }

        $this->assign('num' , count($list1));
        $this->assign('list' , $list2);
        $this->assign('userInfo' , $userInfo);
        $this->assign('openid' , $openid);
        $this->display();
    }

    public function opinion(){
        $openid = I('openid');

        $this->assign('openid' , $openid);
        $this->display();
    }

    public function sendOpinion(){
        if (IS_POST){
           $type = I('post.type');
           $content = I('post.content');
           $openid = I('post.openid');
           if ($type == "" || $content == ""){
               exit(json_encode(array('res' => 0 , 'msg' => '请填写完整信息')));
           }else{

               $userInfo = M('seller')->where('openid = "' . $openid . '"')->find();
               $id = $userInfo['id'];
               $sr_realname = $userInfo['sr_realname'];
               $data = [
                   'sr_id' => $id,
                   'sr_realname' => $sr_realname,
                   'op_content' => $content,
                   'sr_openid' => $openid,
                   'op_type' => $type
               ];
               $res = M('seller_opinion')->data($data)->add();
               if ($res){
                   exit(json_encode(array('res' => 1 , 'msg' => '反馈成功')));
               }else{
                   exit(json_encode(array('res' => 0 , 'msg' => '反馈失败，请重新发送')));
               }
           }

        }
    }

}