<?php

namespace app\index\model;
use think\Model;
use think\Db;
class User extends Model
{
      protected $name = 'loa_user';

      public function getPageResult($filed,$key,$page,$pageSize){
          $where = '';
          if(!in_array(session('type'),array(3,8))){
              $where = array('u.sys_uid'=>session('uid'));
          }
          $query=db('loa_user')->alias('u')
              ->join('sys_user s','u.sys_uid = s.id','left')
              ->join('loa_callback c','c.loa_uid = u.id','left')
              ->join('loa_interest i','i.id = u.int_id','left')
              ->join('loa_area a','a.id = u.area_id','left')
              ->join('loa_car lc','lc.id = c.car_id','left')
              ->field('u.*,s.username as sys_username,count(c.id) AS all_num,c.start_t,i.interest,a.name area,lc.plate');

          if($filed == 'username'){
              $query->where('u.username','like',"%".$key."%");
          }
          if($filed == 'area'){
              $query->where('a.name','like',"%".$key."%");
          }
          if($filed == 'back'){
              $query->where('u.card','like',"%".$key."%");
          }
          if($filed == 'mobile'){
              $query->where('u.mobile','like',"%".$key."%");
          }

          $list =  $query->where($where)
                  ->group('u.id')
                  ->order('u.id desc')
                  ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                  ->toArray();
          return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
      }

    public function getExamineResult($filed,$key,$page,$pageSize){
        $query=db('loa_user')->alias('u')
            ->join('sys_user s','u.sys_uid = s.id','left')
            ->join('loa_callback c','c.loa_uid = u.id','left')
            ->join('loa_interest i','i.id = u.int_id','left')
            ->join('loa_area a','a.id = u.area_id','left')
            ->field('u.*,s.username as sys_username,count(c.id) AS all_num,c.start_t,i.interest,a.name area');

        if($filed == 'username'){
            $query->where('u.username','like',"%".$key."%");
        }
        if($filed == 'area'){
            $query->where('a.name','like',"%".$key."%");
        }
        if($filed == 'back'){
            $query->where('u.card','like',"%".$key."%");
        }
        if($filed == 'mobile'){
            $query->where('u.mobile','like',"%".$key."%");
        }

         $list =  $query->where('u.status',1)
            ->whereOr('u.status',5)
            ->group('u.id')
            ->order('u.id desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

    public function getCarsResult($data,$page,$pageSize,$wheres=array()){
        if(isset($data['filed'])){
            $wheres[$data['filed']] = array('like', '%'.$data['keyword'].'%');
        }
        $list=db('loa_car')->alias('lc')
            ->field('lc.*,lu.username,lu.identity,lu.mobile,lu.card,lu.total,i.interest,p.number,lcb.old_num,lcb.start_t')
            ->join('loa_user lu','lu.id = lc.loa_uid','left')
            ->join('loa_callback lcb','lc.loa_uid = lcb.loa_uid','left')
            ->join('loa_interest i','i.id = lu.int_id','left')
            ->join('loa_periods p','p.id = lu.pid','left')
            ->where($wheres)
            ->order('lc.create_t desc')
            ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
            ->toArray();
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
    }

      public function getByUserInfo($id){
          $list=db('loa_user')->alias('u')
              ->join('loa_callback b','b.loa_uid = u.id','left')
              ->join('loa_interest i','i.id = u.int_id','left')
              ->field('u.*,b.start_t as start,b.car_id,i.interest')
              ->where('u.id',$id)
              ->find();
          return $list;
      }

      public function addUser($data){
          $where['username'] = $data['username'];
          $where['sex'] = $data['sex'];
          $where['identity'] = $data['identity'];
          $where['mobile'] = $data['mobile'];
          $where['pid'] = $data['periods'];
          $where['card'] = $data['card'];
          $where['back'] = $data['back'];
          $where['int_id'] = $data['interest'];
          $where['status'] = 1;
          $where['entry_at'] = $data['start'];
          $where['area_id'] = $data['area'] ?? 0;
          $where['create_t'] = getDateTime();
          $where['update_t'] = getDateTime();
          $where['sys_uid'] = session('uid');
          $where['total'] = $data['total'];
          $uid = db('loa_user')->insertGetId($where);
          $img['loa_uid'] = $uid;
          $img['yinghangka_1'] = $data['yinghangka_1'] ?? '';
          $img['yinghangka_2'] = $data['yinghangka_2'] ?? '';
          $img['shenfenzheng_1'] = $data['shenfenzheng_1'] ?? '';
          $img['shenfenzheng_2'] = $data['shenfenzheng_2'] ?? '';
          $img['liushui'] = isset($data['liushui']) ? implode(',',$data['liushui']) : '';
          $img['zhengxing'] = isset($data['zhengxing']) ? implode(',',$data['zhengxing']) : '';
          $img['shenqingbiao'] = isset($data['shenqingbiao']) ? implode(',',$data['shenqingbiao']) : '';
          $img['jiashizheng'] = $data['jiashizheng'] ?? '';
          db('loa_img')->insert($img);
          $num = db('loa_periods')->where('id',$data['periods'])->value('number');
          $back['new_num'] = $num;
          $back['loa_uid'] = $uid;
          $back['sys_uid'] = session('uid');
		  if(in_array('car_id',array_keys($data))){
			  $back['car_id'] = $data['car_id'];
		      db('loa_car')->where('id',$data['car_id'])->setField('status',1);  
		  }
          $interest = db('loa_interest')->where('id',$data['interest'])->value('interest');
          $num = db('loa_periods')->where('id',$data['periods'])->value('number');
          $money = ((($interest/12*$num)*$data['total'])+$data['total'])/$num; // （（利率 / 12 × 期数）×总额 + 总额）/期数 = 每月应还款
          $back['money'] = sprintf("%.3f",$money);;
          db('loa_callback')->insertGetId($back);
          return $uid;
      }

    public function edit($data){
        $where['username'] = $data['username'];
        $where['sex'] = $data['sex'];
        $where['identity'] = $data['identity'];
        $where['mobile'] = $data['mobile'];
        $where['pid'] = $data['periods'];
        $where['area_id'] = $data['area'] ?? 0;
        $where['entry_at'] = $data['start'];
        $status = db('loa_user')->where('id',$data['id'])->value('status');
        if($status === 3){
            $where['status'] = 1;
        }
        $where['card'] = $data['card'];
        $where['back'] = $data['back'];
        $where['int_id'] = $data['interest'];
        $where['total'] = $data['total'];
        $where['update_t'] = getDateTime();
        $id = db('loa_user')->where('id',$data['id'])->update($where);
        $interest = db('loa_interest')->where('id',$data['interest'])->value('interest');
        $num = db('loa_periods')->where('id',$data['periods'])->value('number');
        $money = ((($interest/12*$num)*$data['total'])+$data['total'])/$num; // （（利率 / 12 × 期数）×总额 + 总额）/期数 = 每月应还款
        $back['money'] = sprintf("%.3f",$money);;
        if(in_array('car_id',array_keys($data))){
			  $back['car_id'] = $data['car_id'];
		      db('loa_car')->where('id',$data['car_id'])->setField('status',1);  
		}
        db('loa_callback')->where('loa_uid',$data['id'])->update($back);
        $img['yinghangka_1'] = $data['yinghangka_1'] ?? '';
        $img['yinghangka_2'] = $data['yinghangka_2'] ?? '';
        $img['shenfenzheng_1'] = $data['shenfenzheng_1'] ?? '';
        $img['shenfenzheng_2'] = $data['shenfenzheng_2'] ?? '';
        $img['liushui'] = isset($data['liushui']) ? implode(',',$data['liushui']) : '';
        $img['zhengxing'] = isset($data['zhengxing']) ? implode(',',$data['zhengxing']) : '';
        $img['shenqingbiao'] = isset($data['shenqingbiao']) ? implode(',',$data['shenqingbiao']) : '';
        $img['jiashizheng'] = $data['jiashizheng'] ?? '';
        db('loa_img')->where('loa_uid',$data['id'])->update($img);
        return $id;
    }

      public function updatePdf($name = '',$pdf,$id,$type=1){
          if($type == 1){
              $id2 = db('loa_pdf')->where(['name'=>$name,'user_car_id'=>$id,'type'=>1])->value('id');
              if($id2){
                  return db('loa_pdf')->where('id',$id2)->update(['user_car_id'=>$id,'name'=>$name,'pdf_url'=>$pdf,'type'=>1]);
              }
              return db('loa_pdf')->insert(['user_car_id'=>$id,'name'=>$name,'pdf_url'=>$pdf,'type'=>1]);
          }else if ($type == 2){
              $id2 = db('loa_pdf')->where(['user_car_id'=>$id,'type'=>2])->value('id');
              if($id2){
                  return db('loa_pdf')->where('id',$id2)->update(['user_car_id'=>$id,'name'=>$name,'pdf_url'=>$pdf,'type'=>2]);
              }
              return db('loa_pdf')->insert(['user_car_id'=>$id,'name'=>$name,'pdf_url'=>$pdf,'type'=>2]);
          }
      }
}