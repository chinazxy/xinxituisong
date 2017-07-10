<?php
/**
 * demo_thinkPHP.php
 *
 * thinkPHP 使用该微信SDK的方法
 *
 * thinkphp 内控制器文件名 TestController.class.php 
 *
 * 使用方法:
 * - 将SDK内 `src` 文件夹重命名为 `Gaoming13`
 * - 拷贝至 `ThinkPHP/Library/` 下即可使用 `Wechat` 和 `Api` 类库.
 * 
 * @author 		gaoming13 <gaoming13@yeah.net>
 * @link 		https://github.com/gaoming13/wechat-php-sdk
 * @link 		http://me.diary8.com/
 */

namespace Home\Controller;
use Think\Controller;
class WeixinController extends Controller {

    public function index(){
        // 这是使用了Memcached来保存access_token
        S(array(
            'type'=>'memcached',
            'host'=>'localhost',
            'port'=>'11211',
            'prefix'=>'think',
            'expire'=>0
        ));

        // 开发者中心-配置项-AppID(应用ID)
        $appId = C('AppID');
        // 开发者中心-配置项-AppSecret(应用密钥)
        $appSecret = C('EncodingAESKey');
        // 开发者中心-配置项-服务器配置-Token(令牌)
        $token = 'hafeisi';
        // 开发者中心-配置项-服务器配置-EncodingAESKey(消息加解密密钥)
        $encodingAESKey = '072vHYArTp33eFwznlSvTRvuyOTe5YME1vxSoyZbzaV';

        // wechat模块 - 处理用户发送的消息和回复消息
        $wechat = new \Gaoming13\WechatPhpSdk\Wechat(array(
            'appId' => $appId,
            'token' => 	$token,
            'encodingAESKey' =>	$encodingAESKey //可选
        ));
        // api模块 - 包含各种系统主动发起的功能
        $api = new \Gaoming13\WechatPhpSdk\Api(
            array('appId' => $appId,'appSecret'	=> $appSecret),
            function(){
                // 用户需要自己实现access_token的返回
                return S('wechat_token');
            },
            function($token) {
                // 用户需要自己实现access_token的保存
                S('wechat_token', $token);
            }
        );

        // 获取微信消息
        $msg = $wechat->serve();

        // 回复文本消息
        if ($msg->MsgType == 'text' && $msg->Content == '你好') {
            $wechat->reply("你也好！ - 这是我回复的额！");
        } else {
            $wechat->reply("听不懂！ - 这是我回复的额！");
        }

        // 主动发送
        $api->send($msg->FromUserName, '这是我主动发送的一条消息');
    }

    public function weixin(){
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = "hafeisi";
        $signature = $_GET['signature'];
        $array = array($timestamp,$nonce,$token);
        sort($array);
//2.将排序后的三个参数拼接后用sha1加密
        $tmpstr = implode('',$array);
        $tmpstr = sha1($tmpstr);

//3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信
        if($tmpstr == $signature)
        {
            echo $_GET['echostr'];
            exit;
        }
    }

    public function getAccessToken(){
        $appid = C('AppID');
        $appsecret = C('appsecret');
        $wx = M('wx_info')->select();
        if (!$wx){
            $TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $json=file_get_contents($TOKEN_URL);
            $result=json_decode($json,true);
            $ACCESS_TOKEN=$result['access_token'];
            $time = time();
            $data = [
                'appid' => $appid,
                'appsecret' => $appsecret,
                'access_token' => $ACCESS_TOKEN,
                'get_time' => $time
            ];
            $re = M('wx_info')->add($data);

        }else{
            $time_b=$wx['get_time'];//上次存的时间
            $time_n=date('Y-m-d H:i:s',time()-7200);

            if($wx['access_token'] == "" || $time_b < $time_n)
            {
                $TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
                $json=file_get_contents($TOKEN_URL);
                $result=json_decode($json,true);
                $ACCESS_TOKEN=$result['access_token'];

                $time = time();
                $data['access_token'] = $ACCESS_TOKEN;
                $data['get_time'] = $time;
                $re = M('wx_info')->where('appid = "' . $appid . '"')->save($data);
            }else{
                $ACCESS_TOKEN = $wx['access_token'];
            }
        }
        echo $ACCESS_TOKEN;
    }

    public function setindustry(){
        header("Content-type:text/html;charset=utf-8");
        $access_token = M('wx_info')->where('appid = "' . C('AppID') . '"')->find()['access_token'];
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=" . $access_token;
        $post = '{"industry_id1" : "31","industry_id2" : "41"}';
        request_post($url , $post);
        $urll = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=" . $access_token;
        $info =request_get($urll);
        var_dump($info);
    }

    public function getmodel(){
        $access_token = M('wx_info')->where('appid = "' . C('AppID') . '"')->find()['access_token'];
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=". $access_token;
        $post = '{"template_id_short":"9sD4EWDzbcfi2Fe3yK2fv45hCEoCM8_1LKZGNH2ilJo"}';
        $info = request_post($url , $post);
        var_dump($info);
        
    }

    public function sendmodel(){
        $access_token = getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $time = time();
        $time = date("Y年m月d日" , $time);
        $post = '{
                               "touser":"oLDLajmYzX2MDnXUNgnCR1EO0Sus",
                               "template_id":"RqPQnjsE39Id2XKxo-wWUenkcDLZdPKIjOxzQAqP0oQ",
                               "data":{
                                       "first": {
                                           "value":"尊敬的用户，您已成功绑定会员账号，详情：",
                                           "color":"#173177"
                                       },
                                       "keyword1":{
                                           "value":"1",
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
        var_dump($r);exit;
    }


}