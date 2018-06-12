<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Loan extends Model
{
   protected $tableName = "loa_callback";

    public function getPageResult($key,$page,$pageSize,$status){
        $list=db('loa_user')->alias('lu')
            ->join('loa_callback lc','lu.id = lc.loa_uid','left')
            ->join('loa_periods lp','lp.id = lu.pid','left')
            ->join('loa_car c','c.id = lc.car_id','left')
            ->field('lc.*,lu.username,lu.mobile,lp.number,c.plate,c.ime,lu.entry_at')
            ->where('lu.username','like',"%".$key."%")
            ->where('lu.status','=',$status)
            ->group('lu.id')
            ->order('lu.id desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

    public function getOverdue($key,$page,$pageSize){
        $list=db('loa_user')->alias('lu')
            ->join('loa_callback lc','lu.id = lc.loa_uid','left')
            ->join('loa_car c','lc.car_id = c.id','left')
            ->join('loa_periods lp','lp.id = lu.pid','left')
            ->join('loa_overdue lo','lu.id = lo.loa_uid','left')
            ->field('lc.*,lu.username,lu.mobile,lp.number,(datediff(now(), lc.next_t)) as  times,lo.type,c.plate')
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

    public function setRemark($user_id,$remark,$name = ''){
        $data['loa_uid'] = $user_id;
        $data['sys_uid'] = session('uid');
        $data['remark'] = $remark;
        $data['name'] = $name;
        $data['created_at'] = getDateTime();
        $data['updated_at'] = getDateTime();
        return db('loa_remark')->insertGetId($data) ?? false;
    }


}