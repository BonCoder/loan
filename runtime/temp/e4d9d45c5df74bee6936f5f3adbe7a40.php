<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"/alidata/www/loan/application/index/view/loan/voucher.html";i:1528343179;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
<link rel="stylesheet" href="__STATIC__/layui/css/modules/layer/default/layer.css" media="all">
<style>
    .cateImage dd {
        position: relative;
        margin: 0 10px 10px 0;
        float: left
    }
    .cateImage .operate {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 1
    }
    .cateImage .operate i {
        cursor: pointer;
        background: #2F4056;
        padding: 2px;
        line-height: 15px;
        text-align: center;
        color: #fff;
        margin-left: 1px;
        float: left;
        filter: alpha(opacity=80);
        -moz-opacity: .8;
        -khtml-opacity: .8;
        position: absolute;
        top:0;
        right:0;
        opacity: .8
    }
</style>
<div class="admin-main fadeInUp animated">
    <form class="layui-form layui-form-pane" method="post" >
        <div class="layui-form-item">
            <label class="layui-form-label">提交凭证</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn1"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage1">
                        <p id="demoText1"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
                <a href="<?php echo url('wait'); ?>" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script src="__JS__/jquery.2.1.1.min.js" ></script>
<script src="__STATIC__/select2/select2.full.js"></script>
<script src="__STATIC__/layui/lay/modules/layer.js"></script>
<script>

    layui.use(['form','upload','layer','laydate'], function () {
        var form = layui.form,upload = layui.upload,layer = layui.layer,laydate = layui.laydate,$ = layui.jquery;

        var uploadInst1 = upload.render({
            elem: '#cateBtn1',
            multiple: true,
            size : '2048',
            url: '<?php echo url("User/upload"); ?>',
            before: function(obj) {
                layer.msg('图片上传中...', {
                    icon: 16,
                    shade: 0.01,
                    time: 0
                })
            },
            done: function(res){
                layer.close(layer.msg());//关闭上传提示窗口
                if(res.code>0){
                    $('#cateImage1').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='fangkuan[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText1');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst1.upload();
                    });

                }
            }
        });

        form.on('submit(submit)', function (data) {
            var fields = $(data.form).serialize();//转换表单数组
            var loading = layer.msg('正在生成PDF和保存数据...', {
                icon: 16
                ,shade: 0.01
                ,time: 10000
            });
            $.post('<?php echo url("voucher"); ?>',fields, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        location.href = res.url;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });

        $('.cateImage').click(function(){
            layer.photos({
                photos: '.cateImage'
                ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
            });
        });

    });

    /*
     删除上传图片
     */
    function UPLOAD_IMG_DEL(divs) {
        $img_url = $("#"+divs).find('input').val();
        $.ajax({
            url : '<?php echo url("User/delfile"); ?>',
            type : "post",
            data : {'img':$img_url},
            dataType : "json",
            success : function(data){
                $("#"+divs).remove();
            }
        })
    }

</script>