<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/4/2 0002
 * Time: 下午 6:05
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class System extends Common
{
    public function index()
    {
        return view('system/other');
    }

    /**
     * Content: 机构列表
     * User: Bob
     * Date: 2018年6月7日
     */
    public function getArea()
    {
        $page =input('page')?input('page'):1;
        $pageSize =input('limit')?input('limit'):config('pageSize');
        $list = db('loa_area')
            ->order('created_at desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

    /**
     * Content: 添加机构
     * User: Bob
     * Date: 2018年6月7日
     */
    public function addArea(Request $request)
    {
        $data = $request->post('name','');
        if($data){
            db('loa_area')->insert(['name'=>$data]);
            return json(['code'=>1,'msg'=>'添加成功']);
        }
        return json(['code'=>0,'msg'=>'添加失败']);
    }

    /**
     * Content: 获取贷款利率列表
     * User: Bob
     * Date: 2018年6月7日
     */
    public function getInterest()
    {
        $page =input('page')?input('page'):1;
        $pageSize =input('limit')?input('limit'):config('pageSize');
        $list = db('loa_interest')
            ->order('create_t desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

    /**
     * Content: 添加贷款利率
     * User: Bob
     * Date: 2018年6月7日
     */
    public function addInterest(Request $request)
    {
        $data = $request->post('interest','');
        if($data){
            db('loa_interest')->insert(['interest'=>$data,'create_t'=>getDateTime()]);
            return json(['code'=>1,'msg'=>'添加成功']);
        }
        return json(['code'=>0,'msg'=>'添加失败']);
    }

    /**
     * Content: 获取贷款期数列表
     * User: Bob
     * Date: 2018年6月7日
     */
    public function getPeriods()
    {
        $page =input('page')?input('page'):1;
        $pageSize =input('limit')?input('limit'):config('pageSize');
        $list = db('loa_periods')
            ->order('created_at desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

    /**
     * Content: 添加贷款期数
     * User: Bob
     * Date: 2018年6月7日
     */
    public function addPeriods(Request $request)
    {
        $data = $request->post('number','');
        if($data){
            db('loa_periods')->insert(['number'=>$data]);
            return json(['code'=>1,'msg'=>'添加成功']);
        }
        return json(['code'=>0,'msg'=>'添加失败']);
    }

    /**
     * Content: 操作记录
     * User: Bob
     * Date: 2018年6月7日
     */
    public function record(Request $request)
    {
       if($request->isPost()){
           $key=input('post.key','');
           $page =input('page')?input('page'):1;
           $pageSize =input('limit')?input('limit'):config('pageSize');
           $list = db('loa_remark')->alias('lr')
               ->field('lr.*,su.username as sys_name,lu.username')
               ->join('sys_user su','su.id = lr.sys_uid')
               ->join('loa_user lu','lu.id = lr.loa_uid')
               ->where('su.username','like',"%".$key."%")
               ->order('lr.created_at desc')
               ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
               ->toArray();
           return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
       }
       $this->assign('title','操作记录列表');
       return view('system/record');
    }


    /**
     * Content: 多个删除
     * User: Bob
     * Date: 2018年6月5日
     */
    public function deleteAll()
    {
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('loa_area')->where($ids)->delete();
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

    /**
     * Content: 多个删除
     * User: Bob
     * Date: 2018年6月5日
     */
    public function deleteInterestAll()
    {
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('loa_interest')->where($ids)->delete();
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

    /**
     * Content: 多个删除
     * User: Bob
     * Date: 2018年6月5日
     */
    public function deletePeriodsAll()
    {
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('loa_periods')->where($ids)->delete();
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