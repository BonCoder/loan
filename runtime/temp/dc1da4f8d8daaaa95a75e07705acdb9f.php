<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"/alidata/www/loan/application/index/view/system/other.html";i:1528250911;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
<!--顶部-->
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
<link rel="stylesheet" href="__CSS__/other.css">
<div class="other-content">
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">机构配置</li>
            <li>利率配置</li>
            <li>贷款期数</li>
            <!--<li>商品管理</li>-->
            <!--<li>订单管理</li>-->
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <button class="layui-btn layui-btn-normal" id="add_Area">添加机构</button>
                <table class="layui-table" id="list" lay-filter="list"></table>
                <button type="button" class="layui-btn layui-btn-danger" id="delAll_Area">批量删除</button>
            </div>
            <div class="layui-tab-item">
                <button class="layui-btn layui-btn-normal" id="add_Interest">添加利率</button>
                <table class="layui-table" id="list2" lay-filter="list2"></table>
                <button type="button" class="layui-btn layui-btn-danger" id="delAll_Interest">批量删除</button>
            </div>
            <div class="layui-tab-item">
                <button class="layui-btn layui-btn-normal" id="add_Periods">添加期数</button>
                <table class="layui-table" id="list3" lay-filter="list2"></table>
                <button type="button" class="layui-btn layui-btn-danger" id="delAll_Periods">批量删除</button>
            </div>
            <div class="layui-tab-item">内容4</div>
            <div class="layui-tab-item">内容5</div>
        </div>
    </div>


</div>
<!--底部-->
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script>
    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
    layui.use(['element','form','table'], function(){
        var element = layui.element,form = layui.form,table = layui.table,$ = layui.jquery;

        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url("getArea"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'id', title: 'id', width: 50, fixed: true},
                {field: 'name', title: '机构', width: 120},
                {field: 'created_at', title: '创建时间', width: 160},
                {field: 'updated_at', title: '更新时间', width: 160},
            ]],
            limit: 10 //每页默认显示的数量
        });
        //添加地区机构
        $('#add_Area').on('click',function () {
            layer.prompt({title: '添加新机构', formType: 3}, function(text, index){
                $.post("<?php echo url('addArea'); ?>", {name:text}, function (res) {
                    if (res.code === 1) {
                        layer.msg(res.msg, {time: 1000, icon: 1},function () {
                            layer.close(index);
                            tableIn.reload();
                        });
                    } else {
                        layer.msg('添加失败！', {time: 1000, icon: 2});
                    }
                });
            });
        });
        $('#delAll_Area').click(function(){
            layer.confirm('确认要删除选中信息吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('post'); //test即为参数id设定的值
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

        var tableIn2 = table.render({
            id: 'interest',
            elem: '#list2',
            url: '<?php echo url("getInterest"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'id', title: 'id', width: 50, fixed: true},
                {field: 'interest', title: '利率', width: 120},
                {field: 'create_t', title: '创建时间', width: 160},
            ]],
            limit: 10 //每页默认显示的数量
        });
        //添加利率
        $('#add_Interest').on('click',function () {
            layer.prompt({title: '添加新利率', formType: 3}, function(text, index){
                $.post("<?php echo url('addInterest'); ?>", {interest:text}, function (res) {
                    if (res.code === 1) {
                        layer.msg(res.msg, {time: 1000, icon: 1},function () {
                            layer.close(index);
                            tableIn2.reload();
                        });
                    } else {
                        layer.msg('添加失败！', {time: 1000, icon: 2});
                    }
                });
            });
        });
        $('#delAll_Interest').click(function(){
            layer.confirm('确认要删除选中信息吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('interest'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('deleteInterestAll'); ?>", {ids: ids}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn2.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })

        var tableIn3 = table.render({
            id: 'periods',
            elem: '#list3',
            url: '<?php echo url("getPeriods"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                {field: 'id', title: 'id', width: 50, fixed: true},
                {field: 'number', title: '期数', width: 120},
                {field: 'created_at', title: '创建时间', width: 160},
                {field: 'updated_at', title: '更新时间', width: 160},
            ]],
            limit: 10 //每页默认显示的数量
        });
        //添加贷款期数
        $('#add_Periods').on('click',function () {
            layer.prompt({title: '添加新期数', formType: 3}, function(text, index){
                $.post("<?php echo url('addPeriods'); ?>", {number:text}, function (res) {
                    if (res.code === 1) {
                        layer.msg(res.msg, {time: 1000, icon: 1},function () {
                            layer.close(index);
                            tableIn3.reload();
                        });
                    } else {
                        layer.msg('添加失败！', {time: 1000, icon: 2});
                    }
                });
            });
        });
        $('#delAll_Periods').click(function(){
            layer.confirm('确认要删除选中信息吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('periods'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('deletePeriodsAll'); ?>", {ids: ids}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn2.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })

    });
</script>
