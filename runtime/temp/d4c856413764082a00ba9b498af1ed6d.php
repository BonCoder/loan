<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:59:"/alidata/www/loan/application/index/view/overdue/index.html";i:1524645825;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
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
        <div class="layui-inline layui-form">
            <select name="filed" id="filed">
                <option value="plate">车牌号</option>
                <option value="username">贷款人</option>
            </select>
        </div>
        <div class="layui-inline">
            <input class="layui-input" id="keyword" name="keyword" placeholder="请输入">
        </div>
        <button class="layui-btn" id="search" data-type="reload">搜索</button>
        <a href="<?php echo url('index'); ?>" class="layui-btn">刷新数据</a>
        <button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/html" id="type">
    {{# if(d.type == 0){ }}
    <span style="color: #999;">未开始拖车</span>
    {{# }else if(d.type == 1){ }}
    <span style="color: #5FB878;">拖车中</span>
    {{# }else if(d.type == 2){ }}
    <span style="color: #ff0000;">拖车成功</span>
    {{# } }}
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="confirm">确认还款</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
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
                {field: 'id', title: 'id', width: 50, fixed: true},
                {field: 'username', title: '姓名', width: 100},
                {field: 'plate', title: '车牌号', width: 150},
                {field: 'take_t', title: '拖车日期', width: 180},
                {field: 'cost', title: '拖车费用', width: 150},
                {field: 'address', title: '拖车地址', width: 300},
                {field: 'users', title: '拖车人', width: 200},
                {field: 'type', title: '拖车状态', width: 200, toolbar: '#type'},
//                {width: 200, align: 'center', toolbar: '#action'}
            ]],
            limit: 10, //每页默认显示的数量
            done: function(obj){
                element.init();
            }
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
        $('#delAll').click(function(){
            layer.confirm('确认要删除选中信息吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('user'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('delall2'); ?>", {ids: ids}, function (data) {
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