<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加文章分类</title>
    <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/plugins/layer/layer.min.js"></script>
    <link rel="stylesheet" href="/Public/css/plugins/iCheck/custom.css">
    <link href="/Public/css/plugins/chosen/chosen.css?vt=2" rel="stylesheet">
    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <style>
    form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
    </style>
</head>
<body>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>添加文章分类<small></small></h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="<?php echo U('ArticleCate/addCateOp');?>" class="form-horizontal tab-content cmxform form-horizontal m-t" id="commentForm" novalidate="novalidate">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上级分类：</label>
                                <div class="col-sm-4">
                                    <select name="cate_id" required="" id="project_id" aria-required="true" class="form-control chosen-select" tabindex="2">
                                        <option value="0">顶级分类</option>
                                        <?php if(is_array($Info)): foreach($Info as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" hassubinfo="true" <?php if($Info["id"] == $vo['id']): ?>selected<?php endif; ?>><?php echo ($vo["cate_name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                   <span style="color:red">* 此项必填</span>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分类名称：</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" name="cate_name"  id="cate_name" placeholder="分类名称" value="" required="" aria-required="true">
                                </div>
                                <div class="col-sm-4">
                                   <span style="color:red">* 此项必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分类描述：</label>
                                <div class="col-sm-4">
                                    <textarea name="cate_desc" id="" cols="43" rows="5" required="" aria-required="true"></textarea>
                                </div>
                                <div class="col-sm-4">
                                   <span style="color:red">* 此项必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 text-right">
                                    <button class="btn btn-white" type="button" onclick="javascript:history.go(-1)">取消</button>
                                    <button class="btn btn-primary" type="submit" id="sure">保存内容</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
            
<script src="/Public/js/jquery.validate.js"></script>
<script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
<script src="/Public/js/content.min.js?v=1.0.0"></script>
<script src="/Public/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/Public/js/plugins/chosen/chosen.jquery.js"></script>
<script>
    $(document).ready(function(){
        $(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",});
    });
</script>
<script src="/Public/js/demo/form-advanced-demo.min.js"></script>
<script src="/Public/js/plugins/iCheck/icheck.min.js"></script>
<script>
    var validateErrorCircleHtml = "<i class='fa fa-times-circle'></i>&nbsp;";
    var msg = '';
    $('#commentForm').validate({
        onkeyup: false,
        ignore: "",
        errorElement: "span",
        errorClass: "help-block m-b-none",

        rules: {
            'cate_name': {
                required: true,
                remote: {
                    url: "<?php echo U('ArticleCate/getCateNameExist');?>",
                    type: 'post',
                    dataType: "json",
                    data: {
                        cate_name: function () {
                            return $('#cate_name').val();
                        },
                        type:function(){
                            var type = 'add';
                            return type;
                        }
                    },
                    dataFilter: function (data) {
                        console.log(data);
                        if (data == 2) {
                            return true;
                        }else if (data == 1) {
                            msg = '分类名称已经存在';
                            swal(msg, "", "error"); 
                            return false;
                            
                        }
                    }
                }
            },
            'cate_desc':{
                required: true,
            }

        },

        messages: {

            'cate_name': {
                required: validateErrorCircleHtml + '分类名称不能为空',
                remote:'此分类已存在'
            },
            'cate_desc':{
                required: validateErrorCircleHtml + '分类描述不能为空'
            }

        },

        errorPlacement: function (error, label) {
            label.parents('.form-group').addClass('has-error');
            label.after(error);
            label.siblings('*:last').after(error);
            label.parents('#showmsg').after(error);

        },
        submitHandler: function (form) {
            form.submit();
        },
        success: function (error, label) {
            $(label).parents('.form-group').removeClass('has-error').addClass('has-success');
            $(error).remove();
        }
    });


</script>


</body>
</html>