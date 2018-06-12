<?php
namespace app\index\controller;

use app\index\model\Overdue as OverdueModel;
use think\Db;
use think\Request;

class Overdue extends Common
{

    /**
     * Content: 拖车统计.
     * User: Bob
     * Date: 2018年3月27日
     */
    public function index(Request $request){
        if(request()->isPost()){
            $Overdue = new OverdueModel();
            $data=$request->post();
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            return $Overdue->getOverResult($data,$page,$pageSize);
        }
        $this->assign('title','拖车管理');
        return view('overdue/index');
    }

    /**
     * Content: 催收记录.
     * User: Bob
     * Date: 2018年3月27日
     */
      public function  collection(){
          if(request()->isPost()){
              $Overdue = new OverdueModel();
              $key=input('post.key');
              $page =input('page')?input('page'):1;
              $pageSize =input('limit')?input('limit'):config('pageSize');
              return $Overdue->getPageResult($key,$page,$pageSize);
          }
          $this->assign('title','催收记录');
          return view('overdue/collection');
      }

    /**
     * Content: 拖车.
     * User: Bob
     * Date: 2018年4月25日
     */
    public function tuoche(Request $request){
        if($request->isPost()){
            $Overdue = new OverdueModel();
            $data = $request->post();
            if($Overdue->add($data)){
                return json(['code'=>1,'mas'=>'添加成功！']);
            }
            return json(['code'=>0,'mas'=>'添加失败！']);
        }
        $uid = input('id');
        $data = db('loa_user')->alias('u')
            ->join('loa_callback lc','lc.loa_uid = u.id','left')
            ->join('loa_car c','c.id = lc.car_id','left')
            ->field('u.id,u.username,c.plate')
            ->where('u.id',intval($uid))
            ->find();
        $this->assign('data',$data);
        return view('overdue/add');
    }

    public function check_uid(){
        $id = input('post.id');
        if(db('loa_overdue')->where('loa_uid',intval($id))->value('id')){
            return json(['code'=>0,'msg'=>'该车正在拖车中！']);
        }
        return json(['code'=>1]);
    }


    public function delall(){
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('loa_collect')->where($ids)->delete();
            // 提交事务
            Db::commit();
            $result['code'] = 1;
            $result['msg'] = '删除成功！';
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $result['code'] = -1;
        }
        return $result;
    }

    public function delall2(){
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('loa_overdue')->where($ids)->delete();
            // 提交事务
            Db::commit();
            $result['code'] = 1;
            $result['msg'] = '删除成功！';
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $result['code'] = -1;
        }
        return $result;
    }
}