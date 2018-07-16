<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:59:"/alidata/www/loan/application/index/view/admin/editPwd.html";i:1522658825;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
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
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div class="admin-main fadeInUp animated">
            <fieldset class="layui-elem-field layui-field-title">
                <legend><?php echo $title; ?></legend>
            </fieldset>
            <form class="layui-form layui-form-pane" method="post" >
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-4">
                        <input type="text" name="username" lay-verify="required" placeholder="姓名" class="layui-input" value="<?php echo session('username'); ?>" disabled="">
                    </div>
                    <div class="layui-form-mid layui-word-aux red">*</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-4">
                        <input type="text" name="password" placeholder="密码" lay-verify="required" class="layui-input" value="">
                    </div>
                    <div class="layui-form-mid layui-word-aux red">*</div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
                        <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script src="__JS__/jquery.2.1.1.min.js"></script>
<script src="__STATIC__/layui/lay/modules/layer.js"></script>
<script>
    layui.use('form', function(){
        var form = layui.form, $ = layui.jquery;;
        form.on('submit(submit)', function (data) {
//            var fields = $(data.form).serialize();//转换表单数组
            $.post('<?php echo url("editPwd"); ?>',data.field, function (res) {
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });

    });

</script>
