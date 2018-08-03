<?php
namespace app\index\controller;
use app\index\model\Callback;
use app\index\model\Loan  as LoanModel;
use app\index\model\Repayment;
use think\Controller;
use think\Db;
use think\Request;
use app\index\model\User as UserModel;

class Loan extends Common
{
    /**
     * Content: 贷款回收.
     * User: Bob
     * Date: 2018年3月27日
     */
    public function index()
    {
        if(request()->isPost()){
            $loan = new LoanModel();
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            return $loan->getPageResult($key,$page,$pageSize,7);
        }
        $this->assign('title','贷款回收');

        return view('loan/index');
    }

    /**
     * Content: 电话统计.
     * User: Bob
     * Date: 2018年6月13日
     */
    public function mobile()
    {
        $this->assign('id',input('id',0));

        return view('loan/mobile');
    }

    /**
     * Content: 待放款.
     * User: Bob
     * Date: 2018年6月6日
     */
    public function wait()
    {
        if(request()->isPost()){
            $loan = new LoanModel();
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            return $loan->getPageResult($key,$page,$pageSize,6);
        }
        $this->assign('title','待放款');

        return view('loan/wait');
    }

    /**
     * Content: 通过审核.
     * User: Bob
     * Date: 2018年3月31日
     */
    public function updateStatue(LoanModel $loan){
        $id = input('id',0);
        $status = input('status',1);
        $remark = input('remark','');
        db('loa_user')->where('id',$id)->setField('status',$status);
        $loan->setRemark($id,$remark,'放款失败');

        return json(['code'=>1,'msg'=>'提交成功']);
    }

    /**
     * Content: 待放款.
     * User: Bob
     * Date: 2018年6月6日
     */
    public function voucher(Request $request)
    {
        if(request()->isPost()){
            $user = new UserModel();
            $data = $request->post();
            $imgs = '';
            if(isset($data['fangkuan'])){
                $imgs = $imgs.implode(' ',$data['fangkuan']).' ';
            }
            $pdf = makePDF($imgs,$data['id'].'_fangkuan');   //生成PDF
            $user->updatePdf('放款凭证',$pdf,$data['id'],1);  //添加PDF到数据库
            $insert['fangkuan'] = isset($data['fangkuan']) ? implode(',',$data['fangkuan']) : '';
            if(db('loa_img')->where('loa_uid',$data['id'])->update($insert)){
                db('loa_user')->where('id',$data['id'])->setField('status',7);  //开始还款
                $back['start_t'] = getDateTime();
                $back['next_t'] = date("Y-m-d H:i:s", strtotime("+1 months", strtotime($back['start_t']))); //下次还款日 = 当前时间 + 一个月
                $back['last_t'] = $back['start_t'];
                db('loa_callback')->where('loa_uid',$data['id'])->update($back);  //开始还款
                return json(['code'=>1,'msg'=>'提交成功','url'=>'index']);
            }
            return json(['code'=>0,'msg'=>'提交失败']);
        }
        $this->assign('id',$request->get('id',0));
        $this->assign('title','提交凭证');

        return view('loan/voucher');
    }

    /**
     * Content: 逾期统计.
     * User: Bob
     * Date: 2018年3月27日
     */
    public function overdue()
    {
        if(request()->isPost()){
            $loan = new LoanModel();
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            return $loan->getOverdue($key,$page,$pageSize);
        }
        $this->assign('title','逾期统计');

        return view('loan/overdue');
    }


    /**
     * Content: 账户结清.
     * User: Bob
     * Date: 2018年3月31日
     */
    public function settle()
    {
        $id=input('post.id');
        $num = db('loa_callback')->where('loa_uid',$id)->value('new_num');
        if($num == 0){
            db('loa_user')->where('id',$id)->setField('status',8);
            $result['code'] = 1;
            $result['msg'] = '账户已结清！';
        }else{
            $result['code'] = -1;
            $result['msg'] = '账户还有'.$num.'期没还完！';
        }
    }

    /**
     * Content: 短信提醒.
     * User: Bob
     * Date: 2018年3月27日
     */
    public function remind()
    {
        $info= request()->post();
        $data=db('loa_user')->where('id',$info['id'])->find();
        $sex = $data['sex']==1 ? '先生' : '女士';
        $content = '尊敬的 '.$data['username'].' '.$sex.'您好，您有一笔贷款需处理';
        $status = $this->set_phone($data['mobile'],$content,2);
        $where['loa_uid'] = $info['id'];
        $where['sys_uid'] = session('uid');
        $where['collect_t'] = getDateTime();
        $where['dates'] = $info['times'];
        db('loa_collect')->insertGetId($where);
        if($status == 1){
            $result['code'] = 1;
            $result['msg'] = '发送短信提醒成功！';
        }else{
            $result['code'] = -1;
        }

        return $result;
    }

    public function getRemark(LoanModel $loan)
    {
        $loa_uid = request()->post('id',0);
        $remark = request()->post('remark','');
        $name = request()->post('name','');
        if($remark){
           $loan->setRemark($loa_uid,$remark,$name);

           return json(['code'=>1,'msg'=>'发送成功']);
        }

        return json(['code'=>0,'msg'=>'发送失败']);
    }

    /**
     * Content: 确认还款.
     *
     * User: Bob
     * Date: 2018年3月27日
     */
    public function confirm()
    {
        $data= request()->post();
        $id = db('loa_callback')
            ->where('loa_uid',$data['id'])
            ->inc('old_num')
            ->dec('new_num')
            ->exp('next_t','DATE_ADD(next_t,INTERVAL 1 month)')
            ->exp('last_t','now()')
            ->update();
        $info=db('loa_user')->alias('lu')
            ->join('loa_callback lc','lu.id = lc.loa_uid','left')
            ->field('lc.*,lu.username,lu.sex,lu.mobile')
            ->where('lu.id',$data['id'])
            ->find();
        $sex = $info['sex']==1 ? '先生' : '女士';
        $content = '尊敬的客户'.$info['username'].$sex.'，您的借款HD'.date('YmdHis',time()).'，当期应还'.$info['money'].'元，已于'.date('Y年m月d日',time()).'成功还款,目前还剩'.$info['new_num'].'期未还。';
        $this->set_phone($info['mobile'],$content,2);
        if($id == 1){
            $result['code'] = 1;
            $result['msg'] = '还款成功！';
        }else{
            $result['code'] = -1;
        }

        return $result;
    }

    /**
     * Content: 单个删除还款.
     * User: Bob
     * Date: 2018年3月27日
     */
    public function delete()
    {
        $id = input('post.id');
        db('loa_callback')->where('loa_uid',$id)->delete();
        db('loa_car')->where('loa_uid',$id)->delete();
        $id = db('loa_user')->delete($id);
        if($id == 1){
            $result['code'] = 1;
            $result['msg'] = '删除成功！';
        }else{
            $result['code'] = -1;
        }

        return $result;
    }

    /**
     * Content: 多个删除还款.
     * User: Bob
     * Date: 2018年3月27日
     */
    public function deleteAll()
    {
        $map['loa_id'] =array('in',input('param.ids/a'));
        $ids['id'] =array('in',input('param.ids/a'));
        // 启动事务
        Db::startTrans();
        try{
            Db::table('loa_callback')->where($map)->delete();
            Db::table('loa_car')->where($map)->delete();
            Db::table('loa_user')->where($ids)->delete();
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


    /*发送短信*/
    public function set_phone($Mobile,$Content,$Sms,$SendTime='')
    {
        header("Content-type: text/html; charset=utf-8");
        date_default_timezone_set('PRC'); //设置默认时区为北京时间
        $CorpID = 'XAJS003530';
        $Pwd = 'po@3530';
//        $url = "https://sdk2.028lk.com/sdk2/BatchSend2.aspx?";
        $url = "http://sdk2.028lk.com:9880/sdk2/BatchSend2.aspx?";
        $ContentS = rawurlencode(mb_convert_encoding($Content, "gb2312", "utf-8"));//短信内容做GB2312转码处理
        $curpost = "CorpID=".$CorpID."&Pwd=".$Pwd."&Mobile=".$Mobile."&Content=".$ContentS."&SendTime=".$SendTime;
        if($Sms == 1)
        {
            //GET方式请求
            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 -https
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_URL, $url.$curpost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $result = curl_exec($ch);
            curl_close($ch);
            //$result = file_get_contents($url.$curpost);
        }
        else if($Sms == 2)
        {
            //POST方式请求
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 -https
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curpost);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        else
        {
            $result = -1;
        }
        return $result>0 ? 1 : 0 ;
    }


    public function editField(Request $request, Callback $callback)
    {
        $id = $request->post('id');
        $field = $request->post('field');
        $value = $request->post('value');
        switch ($field){
            case 'next_t':
                $callback->where('id',$id)->setField($field,$value);
                break;
            case 'old_num':
                $data = $callback->where('id',$id)->find();
                $diff = $data->new_num + $data->old_num - $value;
                $callback->where('id',$id)->update([
                    'old_num'=>(int) $value,
                    'new_num'=>$diff,
                ]);
                break;
            default:
                return json(['code'=>0]);
        }

        return json(['code'=>1]);
    }

    public function remark()
    {
        $this->assign('loa_uid',input('loa_uid'));

        return view('loan/remark');
    }

    //上传还款凭证和备注
    public function repayment(Request $request, Repayment $repayment)
    {
        $loa_uid = $request->post('loa_uid',0);
        $imgs = implode(',',$request->post('repayment/a'));
        $remark = $request->post('remark','');

        $repayment->loa_uid = $loa_uid;
        $repayment->back_img = $imgs;
        $repayment->remark = $remark;

        if($repayment->save()){
            return json(['code'=>1,'msg'=>'上传成功']);
        }

        return json(['code'=>0,'msg'=>'上传失败']);
    }

}