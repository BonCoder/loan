<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:54:"/alidata/www/loan/application/index/view/user/car.html";i:1528354990;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
        <legend>车辆列表</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline layui-form">
            <select name="filed" id="filed">
                <option value="plate">车牌号</option>
                <option value="ime">IME</option>
            </select>
        </div>
        <div class="layui-inline">
            <input class="layui-input" id="keyword" name="keyword" placeholder="请输入">
        </div>
        <button class="layui-btn" id="search" data-type="reload">搜索</button>
        <a href="<?php echo url('getCars'); ?>" class="layui-btn">刷新数据</a>
        <a href="<?php echo url('addCar'); ?>" class="layui-btn layui-btn-normal">添加车辆</a>
        <!--<button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>-->
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/html" id="status">
    {{# if(d.status === 0){ }}
    <span style="color:blue">库存中</span>
    {{# } }}
    {{# if(d.status === 1){ }}
    <span style="color: green">已卖出</span>
    {{# } }}
</script>
<script type="text/html" id="action">
      <a href="/index/user/edit?id={{d.id}}" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
      <!--<a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>-->
      <a href="{{d.pdf_url}}" class="layui-btn layui-btn-warm layui-btn-sm" target="_blank">查看PDF</a>
</script>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    layui.use('table', function() {
        var table = layui.table, $ = layui.jquery;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url("getCars"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'id', title: 'id', width: 50, fixed: true},
                {field: 'plate', title: '车牌号', width: 120},
                {field: 'ime', title: 'IME', width: 180},
                {field: 'pingpai', title: '品牌', width: 150},
                {field: 'chejia', title: '车架号', width: 180},
                {field: 'status', title: '状态', width: 180, toolbar: '#status'},
                {field: 'create_t', title: '创建时间', width: 180},
                {field: 'create_t', title: '更新时间', width: 180},
                {width: 250, align: 'center', toolbar: '#action'}
            ]],
            limit: 10 //每页默认显示的数量
        });
        //搜索
        $('#search').on('click', function() {
            tableIn.reload({
                where: {
                    keyword: $('#keyword').val(),
                    filed: $('#filed').val()
                }
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
                layer.confirm('您确定要删除该车辆吗？', function(index){
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