<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:57:"/alidata/www/loan/application/index/view/user/status.html";i:1528343725;s:57:"/alidata/www/loan/application/index/view/common/head.html";i:1521180510;s:59:"/alidata/www/loan/application/index/view/common/footer.html";i:1521644862;}*/ ?>
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
    #cateImage dd {
        position: relative;
        margin: 0 10px 10px 0;
        float: left
    }
    #cateImage .operate {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 1
    }
    #cateImage .operate i {
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
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-4">
                <input type="text" name="username" disabled class="layui-input" value="<?php echo $data['username']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证号</label>
            <div class="layui-input-4">
                <input type="text" name="identity" disabled class="layui-input" value="<?php echo $data['identity']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-4">
                <input type="text" name="mobile" disabled class="layui-input" value="<?php echo $data['mobile']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行卡号</label>
            <div class="layui-input-4">
                <input type="text" name="card" disabled class="layui-input" value="<?php echo $data['card']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行卡</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage2">
                        <?php if(!(empty($images['yinghangka_1']) || (($images['yinghangka_1'] instanceof \think\Collection || $images['yinghangka_1'] instanceof \think\Paginator ) && $images['yinghangka_1']->isEmpty()))): ?>
                        <dd class="item_img_1" id="2">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $images['yinghangka_1']; ?>" src="<?php echo $images['yinghangka_1']; ?>">
                            <input type="hidden" name="yinghangka_1" value="<?php echo $images['yinghangka_1']; ?>">
                        </dd>
                        <?php endif; if(!(empty($images['yinghangka_2']) || (($images['yinghangka_2'] instanceof \think\Collection || $images['yinghangka_2'] instanceof \think\Paginator ) && $images['yinghangka_2']->isEmpty()))): ?>
                        <dd class="item_img_2" id="3">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $images['yinghangka_2']; ?>" src="<?php echo $images['yinghangka_2']; ?>">
                            <input type="hidden" name="yinghangka_2" value="<?php echo $images['yinghangka_2']; ?>">
                        </dd>
                        <?php endif; ?>
                        <p id="demoText2"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-4">
                <?php 
                if($data['sex'] == 1){
                   echo '<input type="text" name="sex" class="layui-input" disabled value="男" title="男">';
                }else{
                   echo '<input type="text" name="sex" class="layui-input" disabled value="女" title="男">';
                }
                 ?>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">贷款期数</label>
                <div class="layui-input-inline">
                        <?php if(is_array($periods) || $periods instanceof \think\Collection || $periods instanceof \think\Paginator): $i = 0; $__LIST__ = $periods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(($vo['id'] == $data['pid'])): ?>
                    <input type="text" name="ime" disabled class="layui-input" value="<?php echo $vo['number']; ?>期">
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">车牌号</label>
            <div class="layui-input-4">
                <?php if(is_array($plate) || $plate instanceof \think\Collection || $plate instanceof \think\Paginator): $i = 0; $__LIST__ = $plate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(($vo['id'] == $data['car_id'])): ?>
                          <input type="text" name="plate" disabled class="layui-input" value="<?php echo $vo['plate']; ?>">
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">贷款利率</label>
                <div class="layui-input-inline">
                    <select name="interest" lay-verify="required" lay-search="">
                        <?php if(is_array($interest) || $interest instanceof \think\Collection || $interest instanceof \think\Paginator): $i = 0; $__LIST__ = $interest;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(($vo['id'] == $data['int_id'])): ?>
                                <option disabled value="<?php echo $vo['id']; ?>" selected><?php echo $vo['interest']; ?></option>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">贷款金额</label>
            <div class="layui-input-4">
                <input type="text" name="total" disabled class="layui-input" value="<?php echo $data['total']; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">进件日</label>
                <div class="layui-input-inline">
                    <input type="text" name="total" disabled class="layui-input" value="<?php echo $data['entry_at']; ?>">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证件照</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage">
                        <?php if(!(empty($images['shenfenzheng_2']) || (($images['shenfenzheng_2'] instanceof \think\Collection || $images['shenfenzheng_2'] instanceof \think\Paginator ) && $images['shenfenzheng_2']->isEmpty()))): ?>
                        <dd class="item_img" id="1">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $images['shenfenzheng_1']; ?>" src="<?php echo $images['shenfenzheng_1']; ?>">
                            <input type="hidden" name="shenfenzheng_1" value="<?php echo $images['shenfenzheng_1']; ?>">
                        </dd>
                        <?php endif; if(!(empty($images['shenfenzheng_2']) || (($images['shenfenzheng_2'] instanceof \think\Collection || $images['shenfenzheng_2'] instanceof \think\Paginator ) && $images['shenfenzheng_2']->isEmpty()))): ?>
                        <dd class="item_img" id="4">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $images['shenfenzheng_2']; ?>" src="<?php echo $images['shenfenzheng_2']; ?>">
                            <input type="hidden" name="shenfenzheng_2" value="<?php echo $images['shenfenzheng_2']; ?>">
                        </dd>
                        <?php endif; ?>
                        <p id="demoText"></p>
                    </div>

                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">流水</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage3">
                        <?php if(is_array($images['liushui']) || $images['liushui'] instanceof \think\Collection || $images['liushui'] instanceof \think\Paginator): if( count($images['liushui'])==0 ) : echo "" ;else: foreach($images['liushui'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                                <dd class="item_img" id="liushui_<?php echo $k; ?>">
                                    <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                                    <input type="hidden" name="liushui[]" value="<?php echo $vo; ?>">
                                </dd>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText3"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">征信</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage4">
                        <?php if(is_array($images['zhengxing']) || $images['zhengxing'] instanceof \think\Collection || $images['zhengxing'] instanceof \think\Paginator): if( count($images['zhengxing'])==0 ) : echo "" ;else: foreach($images['zhengxing'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                                <dd class="item_img" id="zhengxing_<?php echo $k; ?>">
                                    <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                                    <input type="hidden" name="zhengxing[]" value="<?php echo $vo; ?>">
                                </dd>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText4"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申请表</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage5">
                        <?php if(is_array($images['shenqingbiao']) || $images['shenqingbiao'] instanceof \think\Collection || $images['shenqingbiao'] instanceof \think\Paginator): if( count($images['shenqingbiao'])==0 ) : echo "" ;else: foreach($images['shenqingbiao'] as $k=>$vo): if(!(empty($vo) || (($vo instanceof \think\Collection || $vo instanceof \think\Paginator ) && $vo->isEmpty()))): ?>
                                <dd class="item_img" id="shenqingbiao_<?php echo $k; ?>">
                                    <img style="width:250px;height: 180px;" layer-src="<?php echo $vo; ?>" src="<?php echo $vo; ?>">
                                    <input type="hidden" name="shenqingbiao[]" value="<?php echo $vo; ?>">
                                </dd>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <p id="demoText5"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">驾驶证照</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list cateImage" id="cateImage6">
                        <?php if(!(empty($images['jiashizheng']) || (($images['jiashizheng'] instanceof \think\Collection || $images['jiashizheng'] instanceof \think\Paginator ) && $images['jiashizheng']->isEmpty()))): ?>
                        <dd class="item_img" id="8">
                            <img style="width:250px;height: 180px;" layer-src="<?php echo $images['jiashizheng']; ?>" src="<?php echo $images['jiashizheng']; ?>">
                            <input type="hidden" name="jiashizheng" value="<?php echo $images['jiashizheng']; ?>"></dd>
                        <?php endif; ?>
                        <p id="demoText6"></p>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!(empty($remark) || (($remark instanceof \think\Collection || $remark instanceof \think\Paginator ) && $remark->isEmpty()))): ?>
        <div class="layui-form-item">
            <label class="layui-form-label">审核说明</label>
            <div class="layui-input-4">
                <textarea type="text" disabled class="layui-textarea"><?php echo $remark; ?></textarea>
            </div>
            <div class="layui-form-mid layui-word-aux red">*</div>
        </div>
        <?php endif; 
        if(session('type') == '8'|| session('type') == 2){
         ?>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" value="<?php echo $data['id']; ?>" id="loa_id">
                <?php if($data['status'] == 1): ?>
                   <a href="<?php echo url('updateStatue'); ?>?id=<?php echo $data['id']; ?>&status=2" class="layui-btn" >通过</a>
                <?php elseif($data['status'] == 5): ?>
                   <a href="<?php echo url('updateStatue'); ?>?id=<?php echo $data['id']; ?>&status=6" class="layui-btn" >通过</a>
                <?php endif; ?>
                <a class="layui-btn layui-btn-danger" lay-submit="" lay-filter="status">拒绝</a>
            </div>
        </div>
        <?php } ?>
    </form>
</div>
<script type="text/javascript" src="__STATIC__/layui/layui.all.js"></script>


<script src="__JS__/jquery.2.1.1.min.js"></script>
<script src="__STATIC__/layui/lay/modules/layer.js"></script>
<script>
    layui.use(['form','upload','layer','laydate'], function () {
        var form = layui.form,upload = layui.upload,layer = layui.layer,laydate = layui.laydate;
        //普通图片上传
        laydate.render({
            elem: '#test1'
        });
        var uploadInst = upload.render({
            elem: '#cateBtn',
            multiple: true,
            size : '1024',
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
                    $('#image').val(res.url);
                    $('#cateImage').append("<img class='layui-upload-img'  layer-src='__PUBLIC__"+res.url+"' src='__PUBLIC__"+res.url+"' ><input type='hidden' name='pdf_imgs[]' value='__PUBLIC__"+ res.url +"' />");
                }else{
                    //如果上传失败
                    return layer.msg('上传失败');
                }
            },
            error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });

        form.on('submit(submit)', function (data) {
            var fields = $(data.form).serialize();//转换表单数组
            $.post('<?php echo url("User/edit"); ?>',fields, function (res) {
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
                    location.href = 'user/examine';
                });
            });
        });

    });

</script>