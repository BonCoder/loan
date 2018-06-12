<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"/alidata/www/loan/application/index/view/loan/overdue.html";i:1528358818;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
        <a href="<?php echo url('overdue'); ?>" class="layui-btn">刷新数据</a>
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
    <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="send">短信提醒</a>
    <a class="layui-btn layui-btn-sm" lay-event="phone">电话提醒</a>
    {{# if(d.times>4){ }}
    {{# if(d.type == 1){ }}
    <a class="layui-btn layui-btn-danger layui-btn-sm" >拖车中</a>
    {{# }else{ }}
    <a class="layui-btn layui-btn-warm layui-btn-sm" lay-event="tuoche">拖车</a>
    {{# } }}
    {{# } }}
    <!--<a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>-->
</script>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    layui.use(['table','element'], function() {
        var table = layui.table, $ = layui.jquery;
        var element = layui.element;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url("overdue"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'loa_uid', title: 'id', width: 50, fixed: true},
                {field: 'username', title: '姓名', width: 100},
                {field: 'number', title: '总期数', width: 80},
                {field: 'mobile', title: '手机号', width: 150},
                {field: 'start_t', title: '进件日', width: 180},
                {field: 'plate', title: '车牌号', width: 150},
                {field: 'last_t', title: '上次还款日', width: 200},
                {field: 'num', title: '进度', width: 200, toolbar: '#number'},
                {field: 'times', title: '逾期天数', width: 200},
                {width: 300, align: 'center', toolbar: '#action'}
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
            if (obj.event === 'is_lock') {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post('<?php echo url("usersState"); ?>', {'id': data.id}, function (res) {
                    layer.close(loading);
                    if (res.status ===1) {
                        if (res.is_lock === 1) {
                            obj.update({
                                is_lock: '<a class="layui-btn layui-btn-mini layui-btn-danger" lay-event="is_lock">禁用</a>'
                            });
                        } else {
                            obj.update({
                                is_lock: '<a class="layui-btn layui-btn-mini layui-btn-warm" lay-event="is_lock">正常</a>'
                            });
                        }
                    } else {
                        layer.msg('操作失败！', {time: 1000, icon: 2});
                        return false;
                    }
                })
            }else if (obj.event === 'del') {
                layer.confirm('您确定要删除该会员吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('usersDel'); ?>",{id:data.id},function(res){
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
            }else if (obj.event === 'send') {
                layer.confirm('您确定要发送吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('remind'); ?>",{id:data.loa_uid,times:data.times},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.prompt({
                                formType: 2
                                ,title: '请输入催收情况'
                                ,value: ''
                            }, function(value, index){
                                $.post("<?php echo url('getRemark'); ?>",{id:data.loa_uid,remark:value,name:'短信催收'},function(res){
                                    layer.close(index);
                                    if(res.code===1){
                                        layer.msg(res.msg,{time:1000,icon:1});
                                        tableIn.reload();
                                    }else{
                                        layer.msg('发送失败！',{time:1000,icon:2});
                                    }
                                });
                            });
                        }else{
                            layer.msg('发送失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }else if (obj.event === 'tuoche') {
                $.post("<?php echo url('Overdue/check_uid'); ?>",{id:data.loa_uid},function(res){
                    if(res.code===1){
                        layer.open({
                            type: 2,
                            title: '开始拖车',
                            content: "/index/Overdue/tuoche/id/"+data.loa_uid,
                            area: ['600px', '500px'],
                            maxmin: true
                        });
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                    }
                });
            }else if (obj.event === 'phone') {
                layer.prompt({
                    formType: 2
                    ,title: '请输入电话催收情况'
                    ,value: ''
                }, function(value, index){
                    $.post("<?php echo url('getRemark'); ?>",{id:data.loa_uid,remark:value,name:'电话催收'},function(res){
                        layer.close(index);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('发送失败！',{time:1000,icon:2});
                        }
                    });
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