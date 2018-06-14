<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"/alidata/www/loan/application/index/view/user/examine.html";i:1528343790;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
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
        <legend>用户审核</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline layui-form">
            <select name="filed" id="filed" >
                <option value="username">用户姓名</option>
                <option value="area">地区机构</option>
                <option value="back">银行卡</option>
                <option value="mobile">手机号</option>
            </select>
        </div>
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload">搜索</button>
        <a href="<?php echo url('examine'); ?>" class="layui-btn">显示全部</a>
        <!--<button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>-->
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/html" id="is_lock">
    {{# if(d.is_lock==1){ }}
    <a class="layui-btn layui-btn-mini layui-btn-danger" lay-event="is_lock">禁用</a>
    {{# }else{  }}
    <a class="layui-btn layui-btn-mini layui-btn-warm" lay-event="is_lock">正常</a>
    {{# } }}
</script>
<script type="text/html" id="action">
    <button  class="layui-btn layui-btn-normal layui-btn-sm" lay-event="examine"> 开始审核</button>
    <button class="layui-btn layui-btn-warm layui-btn-sm" lay-event="pdf">查看PDF</button>
</script>
<script type="text/html" id="sex">
    {{# if(d.sex =='1'){ }}
     男
    {{# } }}
    {{# if(d.sex =='2'){ }}
      女
    {{# } }}
</script>
<script type="text/html" id="status">
    {{# if(d.status =='1'){ }}
    <span style="color:blue">待审核</span>
    {{# } }}
    {{# if(d.status =='5'){ }}
    <span style="color:blue">待终审</span>
    {{# } }}
</script>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    layui.use('table', function() {
        var table = layui.table, $ = layui.jquery;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url("examine"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'id', title: 'id', width: 50, fixed: true},
                {field: 'username', title: '姓名', width: 120},
                {field: 'sex', title: '性别', width: 60, toolbar: '#sex'},
                {field: 'area', title: '机构', width: 100},
                {field: 'card', title: '银行卡号', width: 200},
                {field: 'mobile',title: '手机号', width: 120},
                {field: 'total', title: '贷款金额', width: 100},
                {field: 'interest', title: '利率', width: 80},
                {field: 'sys_username', title: '录入人员', width: 100},
                {field: 'entry_at', title: '进件日', width: 200, sort: true},
                {field: 'status', title: '状态', width: 150, toolbar: '#status'},
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
                where: {
                    key: $('#key').val(),
                    filed: $('#filed').val()
                }
            });
        });



        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'examine') {
                if(data.status === 1){
                    var examine = layui.layer.open({
                        title : "开始审核",
                        type : 2,
                        content : ["getStatus?id="+data.id],
                        area: ['1200px', '600px'],
                        closeBtn: 2,
                        maxmin: true
                    });
                    layer.full(examine);
                }else if(data.status === 5){
                    var info = layui.layer.open({
                        title : "开始审核",
                        type : 2,
                        content : ["getInfo?id="+data.id],
                        area: ['1200px', '600px'],
                        closeBtn: 2,
                        maxmin: true
                    });
                    layer.full(info);
                }

            }else if (obj.event === 'del') {
                layer.confirm('您确定要通过审核吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('agree'); ?>",{id:data.id},function(res){
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
            }else if (obj.event === 'pdf'){
                layer.open({
                    type: 2,
                    title: '查看PDF',
                    content: "<?php echo url('getPdf'); ?>?id="+data.id,
                    area: ['200px', '250px']
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