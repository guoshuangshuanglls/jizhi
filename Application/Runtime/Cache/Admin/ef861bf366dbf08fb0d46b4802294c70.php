<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员用户列表</title>
    <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <link rel="stylesheet" href="/Public/css/plugins/dataTables/dataTables.bootstrap.css">
    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public/css/pagelist.css">
    <link rel="stylesheet" href="/Public/css/plugins/datapicker/datepicker3.css">
</head>
<body>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>用户<small>查找</small></h5>
                        <div class="ibox-tools">
                            <a href="<?php echo U('AdminUser/Userlist');?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-rotate-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper " role="grid">
                            <div class="row">
                                <div class="col-sm-11">
                                    <form action="<?php echo U('AdminUser/Userlist');?>" method="post" class="form-inline" role="form">
                                        <div class="form-group">
                                            <input type="text" placeholder="用户名" class="form-control input-sm" name="search" value="<?php echo ($search); ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-sm btn-primary" value="查询" style="margin-top:5px;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable text-center" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row">
                                    <th>序号</th>
                                    <th>用户名称</th>
                                    <th>用户状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($list)): foreach($list as $k=>$v): ?><tr class="">
                                    <td class="sorting_1"><?php echo ($k+1); ?></td>
                                    <td><?php echo ($v["uname"]); ?></td>
                                    <td><?php if($v["status"] == 1): ?><button class="btn btn-primary">正常使用</button><?php else: ?><button class="btn btn-danger">已经禁用</button><?php endif; ?></td>
                                    <td class=" ">
                                        <a class="updateStatus" idinfo="<?php echo ($v["id"]); ?>" msg="<?php if($v["status"] == 1): ?>禁用<?php else: ?>启用<?php endif; ?>"><?php if($v["status"] == 1): ?>禁用<?php else: ?>启用<?php endif; ?></a>
                                    </td>
                                </tr><?php endforeach; endif; ?>

                            </tbody>
                        </table><div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6 text-right">
                                <div class="pagination" id="DataTables_Table_0_paginate">
                                    <?php echo ($show); ?>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script src="/Public/js/plugins/layer/layer.min.js"></script>
<script src="/Public/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/Public/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script>
    $(".input-daterange").datepicker({
        keyboardNavigation: !1,
        forceParse: !1,
        autoclose: !0
    });
</script>

<script>
    // 上下稿操作
    $('.updateStatus').on('click',function(){
        var this_   = $(this);
        var id      = this_.attr('idinfo');
        var msg     = this_.attr('msg');
        swal({
            title: "您确定要"+msg+"吗",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: msg,
            closeOnConfirm: false
        }, function () {        
            if(id){
                $.post("<?php echo U('AdminUser/banLogin');?>",{id:id},function(data){
                   if(data.status == 1){
                        refresh();
                        swal(msg+"成功！", "success");
                   }
                    
                })
            }
            
        });

    })

    var refresh = function () {
        location.reload();
    }
</script>
</body>
</html>