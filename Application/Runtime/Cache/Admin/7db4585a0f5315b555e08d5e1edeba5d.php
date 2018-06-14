<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加用户</title>
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
                        <h5>添加用户<small></small></h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="<?php echo U('AdminUser/addUserOp');?>" class="form-horizontal tab-content cmxform form-horizontal m-t" id="commentForm" novalidate="novalidate">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名：</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" name="uname"  id="uname" placeholder="请填写用户名！" value="" required="" aria-required="true">
                                </div>
                                <div class="col-sm-4">
                                   <span style="color:red">* 此项必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码：</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" name="pwd1"  id="pwd1" placeholder="请填写密码！" value="" required="" aria-required="true">
                                </div>
                                <div class="col-sm-4">
                                   <span style="color:red">* 此项必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">确认密码：</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" name="pwd2"  id="pwd2" placeholder="请填写确认密码！" value="" required="" aria-required="true">
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
            'uname': {
                required: true,
                remote: {
                    url: "<?php echo U('AdminUser/checkUserInfo');?>",
                    type: 'post',
                    dataType: "json",
                    data: {
                        uname: function () {
                            return $('#uname').val();
                        }
                    },
                    dataFilter: function (data) {
                        console.log(data);
                        if (data == 2) {
                            return true;
                        }else if (data == 1) {
                            msg = '用户名已经存在';
                            swal(msg, "", "error"); 
                            return false;
                            
                        }
                    }
                }
            },
            'pwd1':{
                required: true,
            },
            'pwd2':{
                required: true,
                equalTo: '#pwd1'

            }
        },

        messages: {
            'uname': {
                required: validateErrorCircleHtml + '用户名不能为空',
                remote:'用户已存在'
            },
            'pwd1':{
                required: validateErrorCircleHtml + '请输入密码'
            },
            'pwd2':{
                required: validateErrorCircleHtml + '请输入确认密码',
                equalTo: '两次密码输入不一致'
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