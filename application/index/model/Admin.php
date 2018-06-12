<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Admin extends Model
{
   protected $tableName = "sys_user";

   public function login($username,$password){
       $user = $this->checkName($username);
       if(empty($user)){
           return 1;  //账号不存在
       }elseif($user['status']!=1){
           return 4;  //账户被禁用
       }
       $digest = getPwdSalt($password,$user['salt']);
       if($digest == $user['password']){
           // 找到当前id,更新登录时间和ip
           $data['last_time'] = getDateTime();
           $data['last_ip'] = getIp();
           db('sys_user')->where('id',$user['id'])->where('status',1)->update($data);
           session('username',$username);
           session('uid',$user['id']);
           session('type',$user['type']);
           return 2;  //登录成功
       }
       return 3;  //密码错误
   }

    public function getPageResult($key,$page,$pageSize){
        $list=db('sys_user')->alias('u')
            ->join('sys_type t','u.type = t.id','left')
            ->field('u.*,t.t_name')
            ->where('u.username','like',"%".$key."%")
            ->where('u.id','neq', session('uid'))
            ->order('u.id desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

   public function updatePwd($password){
       $a = setPwdSalt($password);
       return db('sys_user')->where('id',session('uid'))->update(['password'=>$a['password'],'salt'=>$a['salt']]);
   }

   public function checkName($username){
       $user = Db::table('sys_user')->where('username',$username)->find();
       return $user;
   }

}