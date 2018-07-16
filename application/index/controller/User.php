<?php
namespace app\index\controller;

use app\index\model\User as UsersModel;
use think\File;
use think\Db;
use think\Request;
use app\index\model\Loan as LoanModel;
use app\index\model\Car as CarModel;

class User extends Common
{
    //会员列表
   public function index(){
       if(request()->isPost()){
           $user = new UsersModel();
           $filed=input('post.filed');
           $key=input('post.key','');
           $page =input('page')?input('page'):1;
           $pageSize =input('limit')?input('limit'):config('pageSize');
           return $user->getPageResult($filed,$key,$page,$pageSize);
       }
      return view('user/index');
   }

    /**
     * Content: 会员审核列表.
     * User: Bob
     * Date: 2018年3月31日
     */
    public function examine(){
        if(request()->isPost()){
            $user = new UsersModel();
            $filed=input('post.filed');
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            return $user->getExamineResult($filed,$key,$page,$pageSize);
        }
        return view('user/examine');
    }

    /**
     * Content: 开始审核.
     * User: Bob
     * Date: 2018年3月31日
     */
    public function getStatus($id){
        $user = new UsersModel();
        //获得个人信息
        $result = $user->getByUserInfo($id);
        //获取pdf图片
        $images = db('loa_img')->where('loa_uid',$id)->find();
        $images['liushui'] = explode(',',$images['liushui']);
        $images['zhengxing'] = explode(',',$images['zhengxing']);
        $images['shenqingbiao'] = explode(',',$images['shenqingbiao']);
        $periods = db('loa_periods')->select();
        $interest = db('loa_interest')->select();
        $area = db('loa_area')->select();
        $plate = db('loa_car')->field('id,plate')->select();
        $remark = db('loa_remark')->where('loa_uid',$id)->column('remark');
        $this->assign([
            'data'=>$result,
            'images'=>$images,
            'interest'=>$interest,
            'periods'=>$periods,
            'area'=>$area,
            'plate'=>$plate,
            'remark'=>implode(',',$remark)
        ]);
        $this->assign('title','开始审核');
        return view('user/status');
    }

    /**
     * Content: 通过审核.
     * User: Bob
     * Date: 2018年3月31日
     */
    public function updateStatue(LoanModel $loan){
        $id = input('id',0);
        $status = input('status');
        $remark = input('remark','');
        db('loa_user')->where('id',$id)->setField('status',$status);
        if($remark){
            $loan->setRemark($id,$remark,'审核');
        }
        return view('user/examine');
    }

    /**
     * Content: 添加用户.
     */
    public function add(){
       if(request()->isPost()){
           $user = new UsersModel();
           $data = request()->post();
           $uid = $user->addUser($data);
           if($uid){
               $filed_1 = ['yinghangka_1','yinghangka_2','shenfenzheng_1','shenfenzheng_2','jiashizheng'];
               $filed_2 = ['liushui','zhengxing','shenqingbiao'];
               $imgs = '';
               foreach ($data as $key => $value){
                   if(in_array($key,$filed_1)){
                       $imgs .= $value.' ';
                   }
                   if(in_array($key,$filed_2)){
                       $imgs .= implode(' ',$value).' ';
                   }
               }
               $pdf = makePDF($imgs,$uid);
               $user->updatePdf('用户信息',$pdf,$uid,1);
           }
           if($uid){
               $result['code'] = 1;
               $result['msg'] = '保存成功！';
               $result['url'] = 'index';
               return $result;
           }else{
               $result['code'] = 0;
               $result['msg'] = '保存失败！';
               return $result;
           }
       }
       $periods = db('loa_periods')->select();
       $interest = db('loa_interest')->select();
       $plate = db('loa_car')->field('id,plate')->where('status',0)->select();
       $area = db('loa_area')->select();
       $this->assign([
           'periods'=>$periods,     //贷款期数
           'interest'=>$interest,   //贷款利率
           'plate'=>$plate,         //车牌
           'area'=>$area            //机构地区
       ]);
       $this->assign('title','添加用户');
       return view('user/add');
    }

    /**
     * Content: 修改用户.
     */
    public function edit(LoanModel $loan){
        $user = new UsersModel();
        if(request()->isPost()){
            $data = request()->post();
            $uid = $user->edit($data);
            if($uid){
                $imgs = '';
                if(isset($data['yinghangka_1'])){
                    $imgs = $imgs.$data['yinghangka_1'].' ';
                }
                if(isset($data['yinghangka_2'])){
                    $imgs = $imgs.$data['yinghangka_2'].' ';
                }
                if(isset($data['shenfenzheng_1'])){
                    $imgs = $imgs.$data['shenfenzheng_1'].' ';
                }
                if(isset($data['shenfenzheng_2'])){
                    $imgs = $imgs.$data['shenfenzheng_2'].' ';
                }
                if(isset($data['jiashizheng'])){
                    $imgs = $imgs.$data['jiashizheng'].' ';
                }
                if(isset($data['liushui'])){
                    $imgs = $imgs.implode(' ',$data['liushui']).' ';
                }
                if(isset($data['zhengxing'])){
                    $imgs = $imgs.implode(' ',$data['zhengxing']).' ';
                }
                if(isset($data['shenqingbiao'])){
                    $imgs = $imgs.implode(' ',$data['shenqingbiao']).' ';
                }
                $pdf = makePDF($imgs,$data['id']);   //生成PDF
                $user->updatePdf('用户信息',$pdf,$uid,1);  //添加PDF到数据库
            }
            if($uid){
                if($data['remark']){
                    $loan->setRemark($data['id'],$data['remark'],'变更');
                }
                $result['code'] = 1;
                $result['msg'] = '修改成功！';
                $result['url'] = 'index';
                return $result;
            }else{
                $result['code'] = 0;
                $result['msg'] = '修改失败！';
                return $result;
            }
        }
        $id=input('id',0);
        //获得个人信息
        $result = $user->getByUserInfo($id);
        //获取pdf图片
        $images = db('loa_img')->where('loa_uid',$id)->find(); //图片
        $images['liushui'] = explode(',',$images['liushui']);
        $images['zhengxing'] = explode(',',$images['zhengxing']);
        $images['shenqingbiao'] = explode(',',$images['shenqingbiao']);
        $periods = db('loa_periods')->select();
        $interest = db('loa_interest')->select();
        $plate = db('loa_car')->field('id,plate')->select();
        $remark = db('loa_remark')->where(['name'=>'审核','loa_uid'=>$id])->value('remark');
        $area = db('loa_area')->select();
        $this->assign([
            'data'=>$result,          //用户信息
            'images'=>$images,        //保存的图片
            'periods'=>$periods,      //贷款期数
            'interest'=>$interest,    //贷款利率
            'remark'=>$remark,         //修改备注
            'plate'=>$plate,           //车牌号
            'area'=>$area             //地区
            ]);
        $this->assign('title','修改用户');
        return view('user/edit');
    }

    public function getCars(Request $request)
    {
        $car = new CarModel();
        if($request->isPost()){
            $data=$request->post();
            $page =input('page')? intval(input('page')):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');

            return $car->getPageResult($data,$page,$pageSize);
        }

        return view('user/car');
    }

    public function addCar(Request $request)
    {
        if($request->isPost()){
            $car = new CarModel();
            $data = $request->post();
            $car_id = $car->addCar($data);
            if($car_id){

                $imgs = '';
                $fileds = ['dengji','xingshi','jiaoqiangxian','shangyexian','wanshui','jidongche','baoxian','chelia'];
                foreach ($data as $key => $value){
                    if(in_array($key,$fileds)){
                        $imgs = $imgs.implode(' ',$data['dengji']).' ';
                    }
                }
                $pdf = makePDF($imgs,'car_id_'.$car_id);   //生成PDF
                $car->updatePdf('车辆信息',$pdf,$car_id,2);  //添加PDF到数据库

                return json(['code'=>1,'msg'=>'添加成功','url'=>'getCars']);
            }
        }
        $this->assign('title','添加车辆');

        return view('user/addCar');
    }

    public function editCar(Request $request)
    {
        $car = new CarModel();

        if($request->isPost()){
            $data = $request->post();
            $car_id = $car->editCar($data);
            $fileds_1 = ['dengji','xingshi','jiaoqiangxian','shangyexian','wanshui','jidongche','baoxian','chelia'];

            if($car_id){
                $imgs = '';
                foreach ($data as $key => $value){
                    if(in_array($key,$fileds_1)){
                        $imgs = $imgs.implode(' ',$value).' ';
                    }
                }

                $pdf = makePDF($imgs,'car_id_'.$data['id']);   //生成PDF
                $car->updatePdf('车辆信息',$pdf,$data['id'],2);  //添加PDF到数据库
                return json(['code'=>1,'msg'=>'修改成功','url'=>'getCars']);
            }
        }

        $id = $request->get('id',0);
        $result = $car->getCarIno($id);
        $fileds_2 = ['ime','dengji','xingshi','jiaoqiangxian','shangyexian','wanshui','jidongche','baoxian','chelia'];

        foreach ($result as $key => $value){
           if(in_array($key,$fileds_2)){
               $result[$key] = explode(',',$value);
           }
        }

        $this->assign('data',$result);
        $this->assign('title','修改车辆详情');

        return view('user/editCar');
    }

    public function upload()
    {
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $result['code'] = 1;
            $result['info'] = '图片上传成功!';
            $result['imgid'] = substr($info->getFilename(),1,5);
            $path = str_replace('\\', '/', $info->getSaveName());
            $result['url'] = '/uploads/' . $path;
            return $result;
        } else {
            // 上传失败获取错误信息
            $result['code'] = 0;
            $result['info'] = '图片上传失败!';
            $result['url'] = '';
            return $result;
        }
    }

    /**
     * Content: 查看PDF
     * User: Bob
     * Date: 2018年6月6日
     */
    public function getPdf($id)
    {
        $pdf = db('loa_pdf')->where(['user_car_id'=>$id,'type'=>1])->select();
        $this->assign('pdf',$pdf);
        return view('user/pdf');
    }

    /**
     * Content: 提交请款资料
     * User: Bob
     * Date: 2018年6月6日
     */
    public function upInfo(Request $request)
    {
        if($request->isPost()){
            $user = new UsersModel();
            $data = $request->post();
            $imgs = '';
            if(isset($data['rongzi'])){
                $imgs = $imgs.implode(' ',$data['rongzi']).' ';
            }
            if(isset($data['shouchirongzi'])){
                $imgs = $imgs.implode(' ',$data['shouchirongzi']).' ';
            }
            if(isset($data['shouju'])){
                $imgs = $imgs.implode(' ',$data['shouju']).' ';
            }
            if(isset($data['zuchehetong'])){
                $imgs = $imgs.implode(' ',$data['zuchehetong']).' ';
            }
            if(isset($data['qichexiaoshou'])){
                $imgs = $imgs.implode(' ',$data['qichexiaoshou']).' ';
            }
            if(isset($data['qita'])){
                $imgs = $imgs.implode(' ',$data['qita']).' ';
            }
            $pdf = makePDF($imgs,$data['id'].'_qingkuan');   //生成PDF
            $user->updatePdf('请款资料',$pdf,$data['id'],1);  //添加PDF到数据库
            $insert['rongzi'] = isset($data['rongzi']) ? implode(',',$data['rongzi']) : '';
            $insert['shouchirongzi'] = isset($data['shouchirongzi']) ? implode(',',$data['shouchirongzi']) : '';
            $insert['shouju'] = isset($data['shouju']) ? implode(',',$data['shouju']) : '';
            $insert['zuchehetong'] = isset($data['zuchehetong']) ? implode(',',$data['zuchehetong']) : '';
            $insert['qichexiaoshou'] = isset($data['qichexiaoshou']) ? implode(',',$data['qichexiaoshou']) : '';
            $insert['qita'] = isset($data['qita']) ? implode(',',$data['qita']) : '';
            if(db('loa_img')->where('loa_uid',$data['id'])->update($insert)){
                db('loa_user')->where('id',$data['id'])->setField('status',5);  //提交终审
                return json(['code'=>1,'msg'=>'提交成功','url'=>'index']);
            }
            return json(['code'=>0,'msg'=>'提交失败']);
        }
        $this->assign('id',$request->get('id',0));
        return view('user/info');
    }

    /**
     * Content: 查看请款资料
     * User: Bob
     * Date: 2018年6月6日
     */
    public function getInfo($id)
    {
        //获取pdf图片
        $images = db('loa_img')
            ->field('rongzi,shouchirongzi,shouju,zuchehetong,qichexiaoshou,qita')
            ->where('loa_uid',$id)
            ->find();
        $images['rongzi'] = explode(',',$images['rongzi']);
        $images['shouchirongzi'] = explode(',',$images['shouchirongzi']);
        $images['shouju'] = explode(',',$images['shouju']);
        $images['zuchehetong'] = explode(',',$images['zuchehetong']);
        $images['qichexiaoshou'] = explode(',',$images['qichexiaoshou']);
        $images['qita'] = explode(',',$images['qita']);
        $this->assign('images',$images);
        $this->assign('id',$id);
        return view('user/getInfo');
    }

    /**
     * Content: 删除图片
     * User: Bob
     * Date: 2018年3月28日
     */
    public function delfile(){
        $filePath= input('post.img');
        $root = ROOT_PATH_NODS;
        $imageUrl="$root"."$filePath";
        $info = @unlink($imageUrl);
        if($info>0){
            return 1;
        }else{
            return 0;
        }
    }

    public function delete($id=''){
        db('loa_callback')->where('loa_uid',$id)->delete();
        db('loa_car_user_id')->where('loa_uid',$id)->delete();
        UsersModel::destroy($id);
        return $result = ['code'=>1,'msg'=>'删除成功!'];
    }

    public function delall(){
        $map['loa_uid'] =array('in',input('param.ids/a'));
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('loa_callback')->where($map)->delete();
            Db::table('loa_car_user_id')->where($map)->delete();
            Db::table('loa_user')->where($ids)->delete();
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