<?php
namespace app\index\controller;

use think\Controller;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Upload extends Controller
{
    public static function file($file=''){
//        if( !$file ){
//            return '';
//        }

//        $file = ROOT_PATH.'/public/pdf/jinhaidun_77.pdf';  //这里我代用了一个图片地址

        $str = explode('.',$file);
        $ext = $str[count($str)-1]; // 获取后缀名

        $config = config('qiniu');

        // 构建一个鉴权对象
        $auth = new Auth($config['AccessKey'],$config['SecretKey']);

        // 生成上传的token
        $token = $auth->uploadToken($config['Bucket']);
        // 上传到七牛后保存的文件名
        $key = date('Y').'/'.date('m').'/'.substr(md5($file),0,5).date('YmdHis').mt_rand(0,9999).'.'.$ext;

        // 初始化UploadManager类
        $uploadMgr = new UploadManager();
        list($ret,$err) = $uploadMgr->putFile($token,$key,$file);
        if($err !== null){
            return '';
        }else{
            // return $key;
            return $key;
        }
    }

}