<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"/alidata/www/loan/application/index/view/user/editCar.html";i:1528857424;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1528860026;}*/ ?>
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
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo $title; ?></legend>
    </fieldset>
    <form class="layui-form layui-form-pane" method="post" >
        <div class="layui-form-item">

            <label class="layui-form-label">车牌号</label>
            <div class="layui-input-4">
                <input type="text" name="plate" lay-verify="required" placeholder="车牌号" class="layui-input" value="<?php echo $data['plate']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">品牌</label>
            <div class="layui-input-4">
                <input type="text" name="pingpai" placeholder="品牌" lay-verify="required" class="layui-input" value="<?php echo $data['pingpai']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">型号</label>
            <div class="layui-input-4">
                <input type="text" name="xinghao" placeholder="型号" lay-verify="required" class="layui-input" value="<?php echo $data['xinghao']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">IME</label>
            <div class="layui-input-2" id="ime">
                <?php if(is_array($data['ime']) || $data['ime'] instanceof \think\Collection || $data['ime'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['ime'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <input type="text" name="ime[]" placeholder="IME" lay-verify="required" class="layui-input" value="<?php echo $vo; ?>">
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <i class="layui-icon layui-form-mid layui-icon-add-circle-fine" id="addIME" style="font-size: 30px; color: #1E9FFF;font-weight:bold">&#xe608;</i>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">车架号</label>
            <div class="layui-input-4">
                <input type="text" name="chejia" placeholder="车架号" lay-verify="required" class="layui-input" value="<?php echo $data['chejia']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登记证</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn1"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage1">
                        <?php if(is_array($data['dengji']) || $data['dengji'] instanceof \think\Collection || $data['dengji'] instanceof \think\Paginator): if( count($data['dengji'])==0 ) : echo "" ;else: foreach($data['dengji'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                                <dd class="item_img" id="shenqingbiao_<?php echo $k; ?>">
                                    <div class="operate">
                                        <i onclick=UPLOAD_IMG_DEL("shenqingbiao_<?php echo $k; ?>") class="close layui-icon"></i></div>
                                    <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                                    <input type="hidden" name="dengji[]" value="<?php echo $vo; ?>">
                                </dd>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText1"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">行驶证</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn2"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage2">
                        <?php if(is_array($data['xingshi']) || $data['xingshi'] instanceof \think\Collection || $data['xingshi'] instanceof \think\Paginator): if( count($data['xingshi'])==0 ) : echo "" ;else: foreach($data['xingshi'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="xingshi<?php echo $k; ?>">
                            <div class="operate">
                                <i onclick=UPLOAD_IMG_DEL("xingshi<?php echo $k; ?>") class="close layui-icon"></i></div>
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                            <input type="hidden" name="xingshi[]" value="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText2"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">交强险保单</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn3"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage3">
                        <?php if(is_array($data['jiaoqiangxian']) || $data['jiaoqiangxian'] instanceof \think\Collection || $data['jiaoqiangxian'] instanceof \think\Paginator): if( count($data['jiaoqiangxian'])==0 ) : echo "" ;else: foreach($data['jiaoqiangxian'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="jiaoqiangxian<?php echo $k; ?>">
                            <div class="operate">
                                <i onclick=UPLOAD_IMG_DEL("jiaoqiangxian<?php echo $k; ?>") class="close layui-icon"></i></div>
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                            <input type="hidden" name="jiaoqiangxian[]" value="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText3"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商业险保单</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn4"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage4">
                        <?php if(is_array($data['shangyexian']) || $data['shangyexian'] instanceof \think\Collection || $data['shangyexian'] instanceof \think\Paginator): if( count($data['shangyexian'])==0 ) : echo "" ;else: foreach($data['shangyexian'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="shangyexian<?php echo $k; ?>">
                            <div class="operate">
                                <i onclick=UPLOAD_IMG_DEL("shangyexian<?php echo $k; ?>") class="close layui-icon"></i></div>
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                            <input type="hidden" name="shangyexian[]" value="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText4"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">完税证明</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn5"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage5">
                        <?php if(is_array($data['wanshui']) || $data['wanshui'] instanceof \think\Collection || $data['wanshui'] instanceof \think\Paginator): if( count($data['wanshui'])==0 ) : echo "" ;else: foreach($data['wanshui'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="wanshui<?php echo $k; ?>">
                            <div class="operate">
                                <i onclick=UPLOAD_IMG_DEL("wanshui<?php echo $k; ?>") class="close layui-icon"></i></div>
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                            <input type="hidden" name="wanshui[]" value="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText5"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">机动车发票</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn6"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage6">
                        <?php if(is_array($data['jidongche']) || $data['jidongche'] instanceof \think\Collection || $data['jidongche'] instanceof \think\Paginator): if( count($data['jidongche'])==0 ) : echo "" ;else: foreach($data['jidongche'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="jidongche<?php echo $k; ?>">
                            <div class="operate">
                                <i onclick=UPLOAD_IMG_DEL("jidongche<?php echo $k; ?>") class="close layui-icon"></i></div>
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                            <input type="hidden" name="jidongche[]" value="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText6"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">保险发票</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn7"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage7">
                        <?php if(is_array($data['baoxian']) || $data['baoxian'] instanceof \think\Collection || $data['baoxian'] instanceof \think\Paginator): if( count($data['baoxian'])==0 ) : echo "" ;else: foreach($data['baoxian'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="baoxian<?php echo $k; ?>">
                            <div class="operate">
                                <i onclick=UPLOAD_IMG_DEL("baoxian<?php echo $k; ?>") class="close layui-icon"></i></div>
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                            <input type="hidden" name="baoxian[]" value="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText7"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">车辆图片</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="cateBtn8"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list cateImage" id="cateImage8">
                        <?php if(is_array($data['chelia']) || $data['chelia'] instanceof \think\Collection || $data['chelia'] instanceof \think\Paginator): if( count($data['chelia'])==0 ) : echo "" ;else: foreach($data['chelia'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="chelia<?php echo $k; ?>">
                            <div class="operate">
                                <i onclick=UPLOAD_IMG_DEL("chelia<?php echo $k; ?>") class="close layui-icon"></i></div>
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                            <input type="hidden" name="chelia[]" value="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText8"></p>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux red">*可多选</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
                <a href="<?php echo url('getCars'); ?>" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script src="__JS__/jquery.2.1.1.min.js" ></script>
<script src="__STATIC__/layui/lay/modules/layer.js"></script>
<script>

    layui.use(['form','upload','layer'], function () {
        var form = layui.form,upload = layui.upload,layer = layui.layer,$ = layui.jquery;

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
                        "<input type='hidden' name='dengji[]' value='__PUBLIC__"+res.url+"' /></dd>");
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

        var uploadInst2 = upload.render({
            elem: '#cateBtn2',
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
                    $('#cateImage2').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='xingshi[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText2');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst2.upload();
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
                        "<input type='hidden' name='jiaoqiangxian[]' value='__PUBLIC__"+res.url+"' /></dd>");
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
                        "<input type='hidden' name='shangyexian[]' value='__PUBLIC__"+res.url+"' /></dd>");
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
                        "<input type='hidden' name='wanshui[]' value='__PUBLIC__"+res.url+"' /></dd>");
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

        var uploadInst6 = upload.render({
            elem: '#cateBtn6',
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
                    $('#cateImage6').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='jidongche[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText6');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst6.upload();
                    });

                }
            }
        });

        var uploadInst7 = upload.render({
            elem: '#cateBtn7',
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
                    $('#cateImage7').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='baoxian[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText7');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst7.upload();
                    });

                }
            }
        });

        var uploadInst8 = upload.render({
            elem: '#cateBtn8',
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
                    $('#cateImage8').append(
                        '<dd class="item_img" id=' + res.imgid + '>'+
                        '<div class="operate">'+
                        '<i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div>'+
                        "<img style='width:250px;height: 180px;'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' >" +
                        "<input type='hidden' name='chelia[]' value='__PUBLIC__"+res.url+"' /></dd>");
                }else{
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText8');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst8.upload();
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
            $.post('<?php echo url("User/editCar"); ?>',fields, function (res) {
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

    $('#addIME').click(function () {
        $('#ime').append('<input type="text" name="ime[]" placeholder="IME" lay-verify="required" class="layui-input" value="">');
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