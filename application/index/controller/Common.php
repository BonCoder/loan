<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Controller;
class Common extends Controller
{
    protected $mod,$role,$system,$nav,$menudata,$cache_model,$categorys,$module,$moduleid,$adminRules,$HrefId;
    public function _initialize()
    {
        //判断管理员是否登录
        if (!session('uid')) {
            $this->redirect('login/index');
        }
        define('MODULE_NAME',strtolower(request()->controller()));
        define('ACTION_NAME',strtolower(request()->action()));
        $this->role=['index/index','index/main','user/upload'];
        //权限管理
        //当前操作权限ID
        if(session('type')!=8){
            $this->HrefId = MODULE_NAME.'/'.ACTION_NAME;
            //当前管理员权限
            $rules = db('sys_type')->where('id',session('type'))->value('href');
            $this->adminRules = explode(',',strtolower($rules));
            if(!in_array($this->HrefId,$this->role)){
                if(!in_array($this->HrefId,$this->adminRules)){
                    $this->error('您无此操作权限','index/main');
                }
            }
        }
    }

//    空操作
    public function _empty(){
        return $this->error('空操作，返回上次访问页面中...');
    }

}
