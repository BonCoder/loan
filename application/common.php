<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//获取当前时间
function getDateTime(){
    return date('Y-m-d H:i:s',time());
}

//取得IP
function getIp(){
    if (@$_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP']!='unknown') {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown') {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match('/^\d[\d.]+\d$/', $ip) ? $ip : '';
}

//加密
function setPwdSalt($pwd,$hash='sha256'){
    $salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    $pwd=$pwd.'{'.$salt.'}';
    $digest= hash($hash,$pwd,true);
    for ($i = 1; $i < 5000; ++$i) {
        $digest = hash($hash,$digest.$pwd,true);
    }
    return array('password'=>base64_encode($digest),'salt'=>$salt);
}

//解密
function getPwdSalt($pwd,$salt,$hash='sha256'){
    $salted = $pwd.'{'.$salt.'}';
    $digest = hash($hash, $salted, true);
    for ($i = 1; $i < 5000; ++$i) {
        $digest = hash($hash, $digest.$salted, true);
    }
    return base64_encode($digest);
}

function makePDF($filesUrl,$item){
    //读取文件夹中的文件
    $filesnames = scandir(ROOT_PATH .'public/pdf',SCANDIR_SORT_NONE);
    $name = 'jinhaidun_'.$item.'.pdf';
    //判断文件是否存在，存在就删除
    if($a = in_array($name,$filesnames)){
        @unlink(ROOT_PATH .'public/pdf/jinhaidun_'.$item.'.pdf');
    }
    require_once VENDOR_PATH.'tcpdf/tcpdf.php';
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // 设置打印模式
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 001');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    // 设置页眉显示的内容  logo、logo大小、pdf文件名、网站说明(www.xxx.com)
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '金海顿'.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    // 设置页脚显示的内容
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    // 设置页眉字体
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    // 设置页脚的字体
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    // 设置默认等宽字体
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // 设置左、上、右的间距
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // 页眉距离顶部的距离
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // 设置页脚距离底部的距离
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    // 设置是否自动分页  距离底部多少距离时分页
    $pdf->SetAutoPageBreak(TRUE, '15');
    $pdf->setImageScale('1.3');
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    //设置默认字体子集模式
    $pdf->setFontSubsetting(true);
    //设置字体
    $pdf->SetFont('dejavusans', '', 14, '', true);
    //增加一个页面
    $pdf->AddPage();
    // set text shadow effect  设置文字阴影效果
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    //选择的文件夹
//        $hostdir = ROOT_PATH . 'public' . DS . 'uploads/'.date('Ymd');
    //获取文件夹中的全部文件名
//        $filesnames = scandir($hostdir);
    $files = explode(' ',$filesUrl);
    foreach ($files as $pic_url) {
        //如果是图片则添加到pdf中
        if($pic_url){
            $img = file_get_contents($pic_url);
//            if(strstr($name,'png') || strstr($name,'jpeg') || strstr($name,'jpg')) {
            $pdf->Image('@' .$img, '', '', ' ', ' ', '', '', 'N', false, 300, 'C', false, false, 1, false, false, true);
//            }
        }
    }

    //保存PDF
    $saveUrl = ROOT_PATH .'public/pdf/'.$name;
    $pdf->Output($saveUrl, 'F');
    $backUrl = '/public/pdf/'.$name;
    return $backUrl;
}

