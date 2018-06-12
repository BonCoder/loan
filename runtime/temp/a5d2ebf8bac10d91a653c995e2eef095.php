<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"/alidata/www/loan/application/index/view/user/pdf.html";i:1528273394;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo config('sys_name'); ?>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="__CSS__/global.css" media="all">
    <link rel="stylesheet" href="__CSS__/font.css" media="all">
</head>
<body class="skin-0">
<?php foreach($pdf as $key=>$vo): ?>
<div>
    <a href="<?php echo $vo['pdf_url']; ?>" class="layui-btn layui-btn-normal" target="_blank" style="margin-top: 10px;margin-left: 40px"><?php echo $vo['name']; ?></a>
</div>
<?php endforeach; ?>