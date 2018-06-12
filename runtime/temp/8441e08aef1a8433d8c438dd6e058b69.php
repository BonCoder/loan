<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"/alidata/www/loan/application/index/view/user/getInfo.html";i:1528278342;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
            <label class="layui-form-label">融资合同</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage1">
                        <?php if(is_array($images['rongzi']) || $images['rongzi'] instanceof \think\Collection || $images['rongzi'] instanceof \think\Paginator): if( count($images['rongzi'])==0 ) : echo "" ;else: foreach($images['rongzi'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="rongzi_<?php echo $k; ?>">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手持融资合同照片</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage2">
                        <?php if(is_array($images['shouchirongzi']) || $images['shouchirongzi'] instanceof \think\Collection || $images['shouchirongzi'] instanceof \think\Paginator): if( count($images['shouchirongzi'])==0 ) : echo "" ;else: foreach($images['shouchirongzi'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="shouchirongzi_<?php echo $k; ?>">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">收据</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage3">
                        <?php if(is_array($images['shouju']) || $images['shouju'] instanceof \think\Collection || $images['shouju'] instanceof \think\Paginator): if( count($images['shouju'])==0 ) : echo "" ;else: foreach($images['shouju'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="shouju<?php echo $k; ?>">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">租车合同</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage4">
                        <?php if(is_array($images['zuchehetong']) || $images['zuchehetong'] instanceof \think\Collection || $images['zuchehetong'] instanceof \think\Paginator): if( count($images['zuchehetong'])==0 ) : echo "" ;else: foreach($images['zuchehetong'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="zuchehetong<?php echo $k; ?>">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">汽车销售合同</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage5">
                        <?php if(is_array($images['qichexiaoshou']) || $images['qichexiaoshou'] instanceof \think\Collection || $images['qichexiaoshou'] instanceof \think\Paginator): if( count($images['qichexiaoshou'])==0 ) : echo "" ;else: foreach($images['qichexiaoshou'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="qichexiaoshou<?php echo $k; ?>">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">其他</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage6">
                        <?php if(is_array($images['qita']) || $images['qita'] instanceof \think\Collection || $images['qita'] instanceof \think\Paginator): if( count($images['qita'])==0 ) : echo "" ;else: foreach($images['qita'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                        <dd class="item_img" id="qita<?php echo $k; ?>">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                        </dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" id="loa_id" value="<?php echo $id; ?>">
                <a href="<?php echo url('updateStatue'); ?>?id=<?php echo $id; ?>&status=6" class="layui-btn" >通过</a>
                <a class="layui-btn layui-btn-danger" lay-submit="" lay-filter="status">拒绝</a>
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


        $('.cateImage').click(function(){
            layer.photos({
                photos: '.cateImage'
                ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
            });
        });

        //添加拒绝理由
        form.on('submit(status)', function(data){
            layer.prompt({
                formType: 2
                ,title: '请添加拒绝理由'
                ,value: ''
            }, function(value,index){
                var id = $('#loa_id').val();
                $.post("<?php echo url('updateStatue'); ?>",{id:id,remark:value,status:3},function (data) {
                    layer.close(index);
                    location.href = 'examine';
                });
            });
        });

    });

</script>