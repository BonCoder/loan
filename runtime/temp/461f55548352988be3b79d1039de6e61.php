<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:54:"/alidata/www/loan/application/index/view/user/add.html";i:1528699881;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
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
<link  rel="stylesheet" href="__STATIC__/select2/select2.css">
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
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo $title; ?></legend>
    </fieldset>
    <form class="layui-form" method="post" >
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="username" lay-verify="required" placeholder="姓名" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">身份证号</label>
                <div class="layui-input-inline">
                    <input type="text" name="identity" placeholder="身份证号" lay-verify="required|identity" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-inline">
                    <input type="text" name="mobile" placeholder="手机号" lay-verify="required|phone" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">机构地区</label>
                <div class="layui-input-inline">
                    <select id="area" class="form-control tags" style="width:190px;"  name="area" multiple="multiple" lay-ignore>
                        <?php if(is_array($area) || $area instanceof \think\Collection || $area instanceof \think\Paginator): $i = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">银行卡号</label>
                <div class="layui-input-inline">
                    <input type="text" name="card" placeholder="银行卡号" lay-verify="required|number" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">开户行</label>
                <div class="layui-input-inline">
                    <input type="text" name="back" placeholder="开户行" lay-verify="required" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">性别</label>
                <div class="layui-input-inline">
                    <input type="radio" name="sex" lay-filter="is_open" checked value="1" title="男">
                    <input type="radio" name="sex" lay-filter="is_open" value="2" title="女">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">贷款期数</label>
                <div class="layui-input-inline">
                    <select name="periods" lay-verify="required" lay-search="">
                        <?php if(is_array($periods) || $periods instanceof \think\Collection || $periods instanceof \think\Paginator): $i = 0; $__LIST__ = $periods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['number']; ?>期</option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">贷款金额</label>
                <div class="layui-input-inline">
                    <input type="text" name="total" placeholder="贷款金额" lay-verify="required" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">车牌号</label>
                <div class="layui-input-inline">
                    <select id="inputTags" class="form-control tags" style="width: 190px" name="car_id" multiple="multiple" lay-ignore>
                        <?php if(is_array($plate) || $plate instanceof \think\Collection || $plate instanceof \think\Paginator): $i = 0; $__LIST__ = $plate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$plate): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $plate['id']; ?>"><?php echo $plate['plate']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">贷款利率</label>
                <div class="layui-input-inline">
                    <select name="interest" lay-verify="required" lay-search="">
                        <?php if(is_array($interest) || $interest instanceof \think\Collection || $interest instanceof \think\Paginator): $i = 0; $__LIST__ = $interest;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['interest']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">进件日</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="test1" name="start" placeholder="yyyy-MM-dd">
                </div>
                <div class="layui-form-mid layui-word-aux red">*</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行卡</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-drag" id="cateBtn2">
                        <i class="layui-icon"></i>
                        <p>银行卡正面</p>
                    </div>
                    <div class="layui-upload-drag" id="cateBtn2-1">
                        <i class="layui-icon"></i>
                        <p>银行卡反面</p>
                    </div>
                    <div class="layui-upload-list cateImage" id="cateImage2">
                        <p id="demoText2"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证件照</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-drag" id="cateBtn">
                        <i class="layui-icon"></i>
                        <p>身份证正面</p>
                    </div>
                    <div class="layui-upload-drag" id="cateBtn1">
                        <i class="layui-icon"></i>
                        <p>身份证反面</p>
                    </div>
                    <div class="layui-upload-list cateImage" id="cateImage">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">流水</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn3"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage3">
                        <p id="demoText3"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">征信</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn4"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage4">
                        <p id="demoText4"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申请表</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn5"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage5">
                        <p id="demoText5"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">驾驶证照</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn6"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage6">
                        <p id="demoText6"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
                <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script src="__JS__/jquery.2.1.1.min.js" ></script>
<script src="__STATIC__/select2/select2.full.js"></script>
<script src="__STATIC__/layui/lay/modules/layer.js"></script>
<script>

    //多选
    $("#inputTags").select2({
        maximumSelectionLength: 1 //最多能够选择的个数
    });

    $("#area").select2({
        maximumSelectionLength: 1 //最多能够选择的个数
    });

    layui.use(['form','upload','layer','laydate'], function () {
        var form = layui.form,upload = layui.upload,layer = layui.layer,laydate = layui.laydate,$ = layui.jquery;
        var datas = "<option value=''>请选择</option>";
        var moduleid =  $('#moduleid').val();
        var image = '';
        laydate.render({
            elem: '#test1'
        });
        var uploadInst = upload.render({
            elem: '#cateBtn',
            multiple: false,
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
                    $('#cateBtn').remove();
                    $('#cateImage').append(
                         "<dd class='item_img' id=" + res.imgid + ">"+
                        // "<div class='operate'>"+
                        // "<i onclick=UPLOAD_IMG_DEL(" + res.imgid + ") class='close layui-icon'></i></div>"+
                         "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                         "<input type='hidden' name='shenfenzheng_1' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });

                }
            }
        });

        var uploadInst1 = upload.render({
            elem: '#cateBtn1',
            multiple: false,
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
                    $('#cateBtn1').remove();
                    $('#cateImage').append(
                        "<dd class='item_img' id=" + res.imgid + ">"+
                        //                         "<div class='operate'>"+
                        //                         "<i onclick=UPLOAD_IMG_DEL(" + res.imgid + ") class='close layui-icon'></i></div>"+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='shenfenzheng_2' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst1.upload();
                    });

                }
            }
        });

        var uploadInst2 = upload.render({
            elem: '#cateBtn2',
            multiple: false,
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
                    $('#cateBtn2').remove();
                    $('#cateImage2').append(
                        "<dd class='item_img' id=" + res.imgid + ">"+
                        //                         "<div class='operate'>"+
                        //                         "<i onclick=UPLOAD_IMG_DEL(" + res.imgid + ") class='close layui-icon'></i></div>"+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='yinghangka_1' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst2.upload();
                    });

                }
            }
        });

        var uploadInst6 = upload.render({
            elem: '#cateBtn2-1',
            multiple: false,
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
                    $('#cateBtn2-1').remove();
                    $('#cateImage2').append(
                        "<dd class='item_img' id=" + res.imgid + ">"+
                        //                         "<div class='operate'>"+
                        //                         "<i onclick=UPLOAD_IMG_DEL(" + res.imgid + ") class='close layui-icon'></i></div>"+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='yinghangka_2' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst6.upload();
                    });

                }
            }
        });

        var uploadInst3 = upload.render({
            elem: '#cateBtn3',
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
                    $('#cateImage3').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='liushui[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText3');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst3.upload();
                    });

                }
            }
        });

        var uploadInst4 = upload.render({
            elem: '#cateBtn4',
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
                    $('#cateImage4').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='zhengxing[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText4');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst4.upload();
                    });

                }
            }
        });

        var uploadInst5 = upload.render({
            elem: '#cateBtn5',
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
                    $('#cateImage5').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='shenqingbiao[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText5');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst5.upload();
                    });

                }
            }
        });

        var uploadInst7 = upload.render({
            elem: '#cateBtn6',
            multiple: false,
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
                    $('#cateImage6').html(
                        "<dd class='item_img' id=" + res.imgid + ">"+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='jiashizheng' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText6');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst7.upload();
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
            $.post('<?php echo url("User/add"); ?>',fields, function (res) {
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
        form.on('select(moduleid)', function(data){
            showtemplist(data.value,0,form);
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

    function showtemplist(m,t,form){
        var type='_list';
        if(t){
            type='_index';
        }
        var mtlist = modulearr[m]+type;
        var mtshow = modulearr[m]+'_show';

        if(modulearr[m]=='page'){
            mtlist=mtshow ='page';
        }
        $('#template_list').html(datas);
        $('#template_show').html(datas);

        listdatas = showdatas ='';
        for(i=1;i<templatearr.length;i++){
            data = templatearr[i].split(',');
            if(data[0].indexOf(mtlist)  >= 0){
                listdatas  ="<option value='"+data[0]+"'>"+data[1]+"</option>";
                $('#template_list').append(listdatas);
            }
            if(data[0].indexOf(mtshow)  >= 0){
                showdatas ="<option value='"+data[0]+"'>"+data[1]+"</option>";
                $('#template_show').append(showdatas);
            }
        }
        if(form){
            form.render()
        }
    }



</script>