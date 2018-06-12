<?php
namespace app\index\controller;

use app\index\model\Admin as AdminModel;
use think\Db;

class Admin extends Common
{
    /**
     * Content: 管理员列表.
     * User: Bob
     * Date: 2018年4月2日
     */
    public function index(){
        if(request()->isPost()){
            $admin = new AdminModel();
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            return $admin->getPageResult($key,$page,$pageSize);
        }
        $this->assign('title','管理员列表');
        return view('admin/index');
    }

    /**
     * Content: 添加管理员.
     * User: Bob
     * Date: 2018年4月2日
     */
    public function add(){
        if(request()->isPost()){
            $data = request()->post();
            $a = setPwdSalt($data['password']);
            $where['password'] = $a['password'];
            $where['salt'] = $a['salt'];
            $where['username'] = $data['username'];
            $where['type'] = $data['type'];
            $where['create_t'] = getDateTime();
            $where['last_ip'] = getIp();
            $id = db('sys_user')->insertGetId($where);
            if($id>0){
                $result['code'] = 1;
                $result['msg'] = '保存成功！';
                $result['url'] = 'index';
            }else{
                $result['code'] = -1;
                $result['msg'] = '添加管理员失败！';
            }
            return $result;
        }
        $type = db('sys_type')->where('t_statue',1)->select();
        $this->assign('title','添加管理员');
        $this->assign('type',$type);
        return view('admin/add');
    }

    /**
     * Content: 修改管理员.
     * User: Bob
     * Date: 2018年4月2日
     */
    public function edit(){
        if(request()->isPost()){
            $data = request()->post();
            if(strlen($data['password']) > 0){
                $a = setPwdSalt($data['password']);
                $where['password'] = $a['password'];
                $where['salt'] = $a['salt'];
            }
            $where['username'] = $data['username'];
            $where['type'] = $data['type'];
            $uid = db('sys_user')->where('id',$data['id'])->update($where);
            if($uid>0){
                $result['code'] = 1;
                $result['msg'] = '保存成功！';
                $result['url'] = 'index';
            }else{
                $result['code'] = -1;
                $result['msg'] = '修改失败！';
            }
            return $result;
        }
        $id = input('id');
        $type = db('sys_type')->where('t_statue',1)->select();
        $info = db('sys_user')->where('id',$id)->find();
        $this->assign('title','修改管理员信息OR权限');
        $this->assign('type',$type);
        $this->assign('info',$info);
        return view('admin/edit');
    }

    /**
     * Content: 修改密码.
     * User: Bob
     * Date: 2018年4月2日
     */
    public function editPwd(){
        if(request()->isPost()){
            $data = request()->post();
            $admin = new AdminModel();
            $a = $admin->updatePwd($data['password']);
            if($a > 0){
                $result['code'] = 1;
                $result['msg'] = '保存成功！';
                $result['url'] = '/index/index/index';
            }else{
                $result['code'] = -1;
                $result['msg'] = '修改失败！';
            }
            return $result;
        }
        $this->assign('title','修改账户密码');
        return view('admin/editPwd');
    }

    /**
     * Content: 修改用户状态.
     * User: Bob
     * Date: 2018年4月2日
     */
    public function updateStatus(){
         $id = input('post.id');
         $status = db('sys_user')->where('id',$id)->value('status');
         $status = ($status == 1) ? 2 : 1;
         $a = db('sys_user')->where('id',$id)->setField('status',$status);
        if($a>0){
            $result['code'] = 1;
            $result['msg'] = '保存成功！';
            $result['status'] = $status;
            $result['is_lock'] = $status;
        }else{
            $result['code'] = 1;
            $result['msg'] = '保存成功！';
            $result['status'] = $status;
            $result['is_lock'] = $status;
        }
        return $result;
    }

    /**
     * Content: 删除.
     * User: Bob
     * Date: 2018年4月2日
     */
    public function delete($id=''){
        db('sys_user')->where('id',$id)->delete();
        return $result = ['code'=>1,'msg'=>'删除成功!'];
    }

    /**
     * Content: 批量删除.
     * User: Bob
     * Date: 2018年4月2日
     */
    public function delall(){
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('sys_user')->where($ids)->delete();
            // 提交事务
            Db::commit();
            $result['code'] = 1;
            $result['msg'] = '删除成功！';
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $result['code'] = -1;
            $result['msg'] = $e;
        }
        return $result;
    }
}