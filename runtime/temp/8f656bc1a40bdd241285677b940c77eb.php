<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:55:"/alidata/www/loan/application/index/view/admin/add.html";i:1522663022;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
                        <input type="text" name="username" lay-verify="required" placeholder="姓名" class="layui-input" value="" >
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
                    <label class="layui-form-label">账户权限</label>
                    <div class="layui-input-4">
                        <select name="type" lay-verify="required" >
                            <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vv['id']; ?>"><?php echo $vv['t_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
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
        <fieldset class="layui-elem-field" style="width: 800px;">
            <legend>说明</legend>
            <div class="layui-field-box">
                <p style="font-size: 16px;">
                1.	 录入（录入基本信息，上传相关资料）<br>
                2.	审核（核查录入信息的准确性，有错误可不通过，打回录入权限）<br>
                3.	变更（客户信息有更改的，如身份证到期，银行卡注销换卡，手机号更换等）<br>
                4.	财务（主要进行还款确认的标记，及客户是否结清）<br>
                5.	贷后管理 （进行短信提醒催款，查看催收记录）<br>
                </p>
            </div>
        </fieldset>
    </div>

<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script src="__JS__/jquery.2.1.1.min.js"></script>
<script src="__STATIC__/layui/lay/modules/layer.js"></script>
<script>
    layui.use('form', function(){
        var form = layui.form, $ = layui.jquery;;
        form.on('submit(submit)', function (data) {
//            var fields = $(data.form).serialize();//转换表单数组
            $.post('<?php echo url("add"); ?>',data.field, function (res) {
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 2}, function () {
                        location.href = res.url;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });

    });

</script>
