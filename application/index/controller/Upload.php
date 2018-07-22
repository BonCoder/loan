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

    public static function upload($file=''){
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 要上传图片的本地路径
        $filePath = $file->getRealPath();
        $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀
        $config = config('qiniu');
        // 构建一个鉴权对象
        $auth = new Auth($config['AccessKey'],$config['SecretKey']);
        // 生成上传的token
        $token = $auth->uploadToken($config['Bucket']);
        // 上传到七牛后保存的文件名
        $key = date('Y').'/'.date('m').'/'.substr(md5($file),0,5).date('YmdHis').mt_rand(0,9999).'.'.$ext;
        // 初始化UploadManager类
        $uploadMgr = new UploadManager();
        list($ret,$err) = $uploadMgr->putFile($token,$key,$filePath);
        if($err !== null){
            // 上传失败获取错误信息
            $result['code'] = 0;
            $result['info'] = '图片上传失败!';
            $result['url'] = '';
            return $result;
        }else{
            $result['code'] = 1;
            $result['info'] = '图片上传成功!';
            $result['imgid'] = time();
            $result['url'] = ROOT_PATH.DS.$key;
            return $result;
        }
    }

}