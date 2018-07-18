<?php

namespace app\index\model;
use think\Model;
use think\Db;
class Car extends Model
{
      protected $table = 'loa_car';

      protected $pk = 'id';

      public function getPageResult($data,$page,$pageSize){
          $wheres = array();
          if(isset($data['filed'])){
              $wheres[$data['filed']] = array('like', '%'.$data['keyword'].'%');
          }
          $list=db('loa_car')->alias('lc')
              ->field('lc.*,lp.pdf_url')
              ->join('loa_pdf lp','lc.id = lp.user_car_id','left')
              ->where($wheres)
              ->where('type',2)
              ->order('lc.create_t desc')
              ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
              ->toArray();
          return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
      }

      public function getCarIno($id)
      {
          return db('loa_car')->where('id',$id)->find();
      }

      public function addCar($data){
          $where['plate'] = $data['plate'];
          $where['pingpai'] = $data['pingpai'];
          $where['xinghao'] = $data['xinghao'];
          $where['ime'] = implode(',',$data['ime']);
          $where['chejia'] = $data['chejia'];
          $where['dengji'] = isset($data['dengji']) ? implode(',',$data['dengji']) : '';
          $where['xingshi'] = isset($data['xingshi']) ? implode(',',$data['xingshi']) : '';
          $where['jiaoqiangxian'] = isset($data['jiaoqiangxian']) ? implode(',',$data['jiaoqiangxian']) : '';
          $where['shangyexian'] = isset($data['shangyexian']) ? implode(',',$data['shangyexian']) : '';
          $where['wanshui'] = isset($data['wanshui']) ? implode(',',$data['wanshui']) : '';
          $where['jidongche'] = isset($data['jidongche']) ? implode(',',$data['jidongche']) : '';
          $where['baoxian'] = isset($data['baoxian']) ? implode(',',$data['baoxian']) : '';
          $where['chelia'] = isset($data['chelia']) ? implode(',',$data['chelia']) : '';
          $where['create_t'] = getDateTime();
          $car_id = db('loa_car')->insertGetId($where);
          return $car_id;
      }

    public function editCar($data){
        $where['plate'] = $data['plate'];
        $where['pingpai'] = $data['pingpai'];
        $where['xinghao'] = $data['xinghao'];
        $where['ime'] = implode(',',$data['ime']);
        $where['chejia'] = $data['chejia'];
        $where['dengji'] = isset($data['dengji']) ? implode(',',$data['dengji']) : '';
        $where['xingshi'] = isset($data['xingshi']) ? implode(',',$data['xingshi']) : '';
        $where['jiaoqiangxian'] = isset($data['jiaoqiangxian']) ? implode(',',$data['jiaoqiangxian']) : '';
        $where['shangyexian'] = isset($data['shangyexian']) ? implode(',',$data['shangyexian']) : '';
        $where['wanshui'] = isset($data['wanshui']) ? implode(',',$data['wanshui']) : '';
        $where['jidongche'] = isset($data['jidongche']) ? implode(',',$data['jidongche']) : '';
        $where['baoxian'] = isset($data['baoxian']) ? implode(',',$data['baoxian']) : '';
        $where['chelia'] = isset($data['chelia']) ? implode(',',$data['chelia']) : '';
        $where['update_t'] = getDateTime();
        $car_id = db('loa_car')->where('id',$data['id'])->update($where);
        return $car_id;
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