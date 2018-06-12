<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:57:"/alidata/www/loan/application/index/view/admin/index.html";i:1522658825;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo $title; ?></legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload">搜索</button>
        <a href="<?php echo url('index'); ?>" class="layui-btn">刷新数据</a>
        <a href="<?php echo url('add'); ?>" class="layui-btn layui-btn-warm">添加管理员</a>
        <button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/html" id="is_lock">
    {{# if(d.status==1){ }}
    <a class="layui-btn layui-btn-sm layui-btn-warm" style="width: 60px;" lay-event="is_lock">正常</a>
    {{# }else{  }}
    <a class="layui-btn layui-btn-sm layui-btn-danger" style="width: 60px;" lay-event="is_lock">禁用</a>
    {{# } }}
</script>
<script type="text/html" id="action">
      <a href="/index/admin/edit?id={{d.id}}" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
      <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    layui.use('table', function() {
        var table = layui.table, $ = layui.jquery;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'id', title: 'id', width: 50, fixed: true},
                {field: 'username', title: '账户名', width: 120},
                {field: 't_name', title: '账户类型', width: 100},
                {field: 'status', title: '账户状态', width: 100,toolbar: '#is_lock'},
                {field: 'last_time', title: '最近登录时间', width: 160},
                {field: 'last_ip',title: '最近登录IP', width: 160},
                {width: 250, align: 'center', toolbar: '#action'}
            ]],
            limit: 10 //每页默认显示的数量
        });
        //搜索
        $('#search').on('click', function() {
            var key = $('#key').val();
            if($.trim(key)==='') {
                layer.msg('关键字！',{icon:0});
                return;
            }
            tableIn.reload({
                where: {key: key}
            });
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'is_lock') {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post('<?php echo url("updateStatus"); ?>', {'id': data.id}, function (res) {
                    layer.close(loading);
                    if (res.code ===1) {
                        tableIn.reload();
                    } else {
                        layer.msg('操作失败！', {time: 1000, icon: 2});
                        return false;
                    }
                })
            }else if (obj.event === 'del') {
                layer.confirm('您确定要删除该用户吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('delete'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });

        $('#delAll').click(function(){
            layer.confirm('确认要删除选中信息吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('user'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('delall'); ?>", {ids: ids}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
    });
</script>
</body>
</html>