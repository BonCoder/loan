<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    protected $adminRules;
    public function _initialize()
    {
        //判断管理员是否登录
        if (!session('uid')) {
            $this->redirect('login/index');
        }
        define('MODULE_NAME',strtolower(request()->controller()));
        define('ACTION_NAME',strtolower(request()->action()));
        //权限管理
        //当前操作权限ID
        //当前管理员权限
        $rules = db('sys_type')->where('id',session('type'))->value('href');
        $this->adminRules = explode(',',$rules);
    }

    public function index()
    {
        //导航
        // 获取缓存数据
        $authRule = cache('authRule');
        if(!$authRule){
            $authRule = db('sys_auth_rule')->where('menustatus=1')->order('sort')->select();
            cache('authRule', $authRule, 3600);
        }
        //声明数组
        $menus = array();
        foreach ($authRule as $key=>$val){
            if($val['pid']==0){
                if(session('type')!=8){
                    if(in_array($val['href'],$this->adminRules)){
                        $menus[] = $val;
                    }
                }else{
                    $menus[] = $val;
                }
            }
        }
        foreach ($menus as $k=>$v){
            foreach ($authRule as $kk=>$vv){
                if($v['id']==$vv['pid']){
                    if(session('type')!=8) {
                        if (in_array($vv['href'], $this->adminRules)) {
                            $menus[$k]['children'][] = $vv;
                        }
                    }else{
                        $menus[$k]['children'][] = $vv;
                    }
                }
            }
        }
        $this->assign('menus', json_encode($menus,true));
        return view('index/index');
    }

    public function main(){
        $version = Db::query('SELECT VERSION() AS ver');
        $config  = [
            'url'             => $_SERVER['HTTP_HOST'],
            'document_root'   => $_SERVER['DOCUMENT_ROOT'],
            'server_os'       => PHP_OS,
            'server_port'     => $_SERVER['SERVER_PORT'],
            'server_ip'       => $_SERVER['SERVER_ADDR'],
            'server_soft'     => $_SERVER['SERVER_SOFTWARE'],
            'php_version'     => PHP_VERSION,
            'mysql_version'   => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize')
        ];
        $this->assign('config', $config);
        return $this->fetch();
    }

    public function clear(){
        $R = RUNTIME_PATH;
        $this->_deleteDir($R);
//        if ($this->_deleteDir($R)) {
//            $result['info'] = '清除缓存成功!';
//            $result['status'] = 1;
//        } else {
//            $result['info'] = '清除缓存失败!';
//            $result['status'] = 0;
//        }
        $result['info'] = '清除缓存成功!';
        $result['status'] = 1;
        $result['url'] = url('index/index/index');
        return $result;
    }

    private function _deleteDir($R)
    {
        $handle = opendir($R);
        while (($item = readdir($handle)) !== false) {
            if ($item != '.' and $item != '..') {
                if (is_dir($R . '/' . $item)) {
                    $this->_deleteDir($R . '/' . $item);
                } else {
                    if (!unlink($R . '/' . $item))
                        die('error!');
                }
            }
        }
        closedir($handle);
        return rmdir($R);
    }

    //退出登陆
    public function logout(){
        session(null);
        $this->redirect('login/index');
    }

}
