<?php
/**
 * 管理员操作记录
 * @param $log_url 操作URL
 * @param $log_info 记录信息
 */
function adminLog($log_info,$url){
    $add['log_time'] = time();
    $add['admin_id'] = session('admin_id');
    $add['log_info'] = $log_info;
    $add['log_ip'] = getIP();
    $add['log_url'] = $url;
    $a = M('admin_log')->add($add);
}

// 定义一个函数getIP() 客户端IP，
function getIP(){
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}

function request_post($url = '', $param = '')
{
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch); //运行curl
    curl_close($ch);
    return $data;
}

function request_get($url = '')
{
    if (empty($url)) {
        return false;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getAccessToken(){
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
    return $ACCESS_TOKEN;
}
?>