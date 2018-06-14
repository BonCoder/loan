<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:57:"/alidata/www/loan/application/index/view/loan/mobile.html";i:1528862191;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
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
<form class="layui-form" action="" id="phone_send" style="margin-top: 15px;margin-right: 15px">
    <div class="layui-form-item">
        <label class="layui-form-label">选择时间</label>
        <div class="layui-input-block">
            <input type="text" name="send_time" required  lay-verify="required" class="layui-input" id="send_time">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea  name="remark" required  lay-verify="required" class="layui-textarea"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="name" value="电话催收">
            <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
            <a href="<?php echo url('getCar'); ?>" class="layui-btn layui-btn-primary">返回</a>
        </div>
    </div>
</form>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    layui.use(['form','layer','laydate'], function () {
        var form = layui.form, layer = layui.layer, laydate = layui.laydate, $ = layui.jquery;
        laydate.render({
            elem: '#send_time' //指定元素
        });
        form.on('submit(submit)', function (data) {
            var fields = $(data.form).serialize();//转换表单数组
            var loading = layer.msg('稍等片刻...', {
                icon: 16
                ,shade: 0.01
                ,time: 10000
            });
            $.post('<?php echo url("loan/getRemark"); ?>',fields, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2}, function () {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        });
    })
</script>