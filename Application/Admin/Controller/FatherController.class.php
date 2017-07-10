<?php
namespace Admin\Controller;

use Think\Controller;

class FatherController extends Controller {



    /*
    * 初始化操作
    */
    public function _initialize()
    {

            if(session('admin_id') > 0 ){
                $admin_id = session('admin_id');
                $admin_name = M('admin')->where(array('admin_id' => $admin_id))->find();
                $role_id = session('role_name');
                $role_name = M('admin_role')->where(array('role_id' => $role_id))->find();
                $this->assign('sys_info',$this->get_sys_info());
                $this->assign('admin_img' , $admin_name['admin_pic']);
                $this->assign('admin_name' , $admin_name['username']);
                $this->assign('role_name' , $role_name['role_name']);
                $this->check_priv();//检查管理员菜单操作权限
            }else{
                $this->error('请先登陆',U('Admin/Login/index'),1);
            }

    }

    public function check_priv()
    {
        $ctl = CONTROLLER_NAME;
        $act = ACTION_NAME;
        $act_list = session('nav_list');
        //$no_check = array('login','logout','vertifyHandle','vertify','imageUp','upload','welcome');
        if($ctl == "Index" && $act == 'index'){
            return true;
        }elseif(strpos('ajax',$act) || $act_list == 'all'){
            return true;
        }else{
//            $mod_id = M('system_module')->where("ctl='$ctl' and act='$act'")->getField('mod_id');
//
//            $act_list = explode(',', $act_list);
//
//            if($mod_id){
//                if(!in_array($mod_id, $act_list)){
//                    //$this->error('您的账号没有此菜单操作权限,超级管理员可分配权限',U('Admin/Index/index'));
//                    exit;
//                }else{
//                    return true;
//                }
//            }else{
//                //$this->error('请系统管理员先在菜单管理页添加该菜单',U('Admin/System/menu'));
//                exit;
//            }
        }
    }

    public function get_sys_info(){

        $sys_info['os']             = PHP_OS;
        $sys_info['zlib']           = function_exists('gzclose') ? 'YES' : 'NO';//zlib
        $sys_info['safe_mode']      = (boolean) ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = Off
        $sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
        $sys_info['curl']			= function_exists('curl_init') ? 'YES' : 'NO';
        $sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];
        $sys_info['phpv']           = phpversion();
        $sys_info['ip'] 			= GetHostByName($_SERVER['SERVER_NAME']);
        $sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
        $sys_info['max_ex_time'] 	= @ini_get("max_execution_time").'s'; //脚本最大执行时间
        $sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
        $sys_info['domain'] 		= $_SERVER['HTTP_HOST'];
        $sys_info['memory_limit']   = ini_get('memory_limit');
        $sys_info['version']   		= file_get_contents('./Application/Admin/Conf/version.txt');
        $dbPort = C("DB_PORT"); $dbHost = C("DB_HOST");
        $dbHost = empty($dbPort) || $dbPort == 3306 ? $dbHost : $dbHost.':'.$dbPort;
        mysql_connect($dbHost, C("DB_USER"), C("DB_PWD"));
        $sys_info['mysql_version']   = mysql_get_server_info();
        if(function_exists("gd_info")){
            $gd = gd_info();
            $sys_info['gdinfo'] 	= $gd['GD Version'];
        }else {
            $sys_info['gdinfo'] 	= "未知";
        }
        return $sys_info;
    }
}

?>