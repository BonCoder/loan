<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:56:"/alidata/www/loan/application/index/view/index/main.html";i:1522160151;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
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
<div class="admin-main layui-anim layui-anim-upbit">
    <div class="table-responsive">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>系统信息</legend>
        </fieldset>
        <table class="layui-table" lay-even lay-skin="line">
            <colgroup>
                <col width="40%">
                <col>
            </colgroup>
            <thead>
                </thead>
            <tbody>
            <tr>
                <td>网站域名</td>
                <td><?php echo $config['url']; ?></td>
            </tr>
            <tr>
                <td>网站目录</td>
                <td><?php echo $config['document_root']; ?></td>
            </tr>
            <tr>
                <td>服务器操作系统</td>
                <td><?php echo $config['server_os']; ?></td>
            </tr>
            <tr>
                <td>服务器端口</td>
                <td><?php echo $config['server_port']; ?></td>
            </tr>
            <tr>
                <td>服务器IP</td>
                <td><?php echo $config['server_ip']; ?></td>
            </tr>
            <tr>
                <td>WEB运行环境</td>
                <td><?php echo $config['server_soft']; ?></td>
            </tr>
            <tr>
                <td>MySQL数据库版本</td>
                <td><?php echo $config['mysql_version']; ?></td>
            </tr>
            <tr>
                <td>运行PHP版本</td>
                <td><?php echo $config['php_version']; ?></td>
            </tr>

            <tr>
                <td>最大上传限制</td>
                <td><?php echo $config['max_upload_size']; ?></td>
            </tr>
            <tr>
                <td>CLTPHP版本</td>
                <td><?php echo config('version'); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    layui.use('table', function() {
        var table = layui.table;
    })
</script>
</body>
</html>