<?php
namespace app\index\controller;
use app\index\model\Admin;
use think\Controller;

class Login extends Controller
{
    public function _initialize(){
        if (session('uid')) {
            $this->redirect('index/index');
        }
    }

    public function index(){
        if(request()->isPost()){
            $login = new Admin();
            $request = request()->post();
            $username = $request['username'];
            $password = $request['password'];
            $code = $request['captcha'];
            if(!$this->check($code)){
                return json(array('code'=>0,'msg'=> '验证码错误'));
            }
            $info = $login->login($username,$password);
            switch ($info){
                case 1:
                    return json(['code' => 0, 'msg' => '用户名不存在!']);
                case 2:
                    return json(['code' => 1, 'msg' => '登录成功!','url' => url('index/index')]);
                case 3:
                    return json(['code' => 0, 'msg' => '用户名或者密码错误，重新输入!']);
                case 4:
                    return json(['code' => 0, 'msg' => '账户被禁言！']);
                default:
                    return json(['code' => 0, 'msg' => '系统故障，暂时无法登陆，请联系管理员']);
            }
        }
        $this->assign('title','登录页面');
        return view('login/index');
    }

    public function check($code){
        return captcha_check($code);
    }
}