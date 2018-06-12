<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:56:"/alidata/www/loan/application/index/view/loan/index.html";i:1528352777;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
        <!--<button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>-->
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/html" id="number">
    <div class="layui-progress layui-progress-big" lay-showPercent="true" style="margin-top: 5px" lay-filter="demo">
        <div class="layui-progress-bar layui-bg-blue" lay-percent="{{d.old_num}} / {{d.number}}"></div>
    </div>
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="confirm">确认还款</a>
    {{# if(d.old_num+1 == d.number){ }}
    <a class="layui-btn layui-btn-warm layui-btn-sm" lay-event="settle">确认结清</a>
    {{# } }}
</script>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    layui.use(['table','element'], function() {
        var table = layui.table, $ = layui.jquery;
        var element = layui.element;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'loa_uid', title: 'id', width: 50, fixed: true},
                {field: 'username', title: '姓名', width: 100},
                {field: 'number', title: '总期数', width: 80},
                {field: 'mobile', title: '手机号', width: 125},
                {field: 'money', title: '每期金额', width: 95},
                {field: 'plate', title: '车牌号', width: 150},
                {field: 'start_t', title: '开始还款日', width: 180},
                {field: 'last_t', title: '上次还款日', width: 180},
                {field: 'next_t', title: '下次还款日', width: 180},
                {field: 'num', title: '进度',style:'background-color: #eee;', width: 240, toolbar: '#number'},
                {width: 200, align: 'center', toolbar: '#action'}
            ]],
            limit: 10, //每页默认显示的数量
            done: function(obj){
                element.init();
            }
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
           if (obj.event === 'settle') {
                layer.confirm('您确定该用户已结清？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('settle'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }else if (obj.event === 'confirm') {
                layer.confirm('您确认已还款？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('confirm'); ?>",{id:data.loa_uid},function(res){
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
                $.post("<?php echo url('deleteAll'); ?>", {ids: ids}, function (data) {
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