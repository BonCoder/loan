<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Overdue extends Model
{
   protected $table = "loa_callback";

    public function getPageResult($key,$page,$pageSize){
        $list=db('loa_collect')->alias('lc')
            ->join('loa_user lu','lu.id = lc.loa_uid','left')
            ->join('sys_user su','su.id = lc.sys_uid','left')
            ->field('lc.*,lu.username,su.username as sysname')
            ->where('lu.username','like',"%".$key."%")
            ->order('lc.id desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }
    public function getOverResult($data,$page,$pageSize,$wheres = array()){
        if(isset($data['filed'])){
            $wheres[$data['filed']] = array('like', '%'.$data['keyword'].'%');
        }
        $list=db('loa_overdue')->alias('lo')
            ->join('loa_car lc','lc.id = lo.car_id','left')
            ->join('loa_user lu','lu.id = lo.loa_uid','left')
            ->field('lo.*,lu.username,lc.plate')
            ->where($wheres)
            ->order('lc.id desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

    public function getOverdue($key,$page,$pageSize){
        $list=db('loa_user')->alias('lu')
            ->join('loa_callback lc','lu.id = lc.loa_uid','left')
            ->join('loa_periods lp','lp.id = lu.pid','left')
            ->field('lc.*,lu.username,lu.mobile,lp.number,(datediff(now(), lc.next_t)) as  times')
            ->where([
                'lu.username'=>['like',"%".$key."%"],
                'datediff(now(),lc.next_t)'=>['>',0]
            ])
            ->group('lu.id')
            ->order('lu.id desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();

        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

    public function add($data){
        $where['users'] = $data['users'];
        $where['take_t'] = $data['start_time'];
        $where['address'] = $data['address'];
        $where['cost'] = $data['cost'];
        $where['car_id'] = $data['id'];
        $where['sys_uid'] = session('uid');
        $where['type'] = 1;
        return db('loa_overdue')->insertGetId($where) ? true : false;
    }

}