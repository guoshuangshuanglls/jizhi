<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文章分类列表</title>
    <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/Public/css/pagelist.css" rel="stylesheet">
    <style>
        .mytipmsg{font-size: 16px;font-weight: bold;}
    </style>
</head>
<body>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>所有文章分类</h5>
                        <div class="ibox-tools">
                            <a href="<?php echo U('ArticleCate/ArticleCateList');?>" class="btn btn-primary btn-sm">返回大分类列表</a>
                            <addButton name="创建广告位置" act="addPosition" arg="pid=$pid" tag="a" style="btn btn-sm btn-success" />
                            <a href="" id="loading-example-btn" class="btn btn-sm btn-success"><i class="fa fa-rotate-right"></i></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-12">
                                <form method="post" action="<?php echo U('AdvPosition/advpositionList',array('pid'=>$pid));?>">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                       
                                        <input placeholder="请输入分类名称" class="input-sm form-control" type="text" name="searchname"> <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="">
                            <?php if($ArticleCateList != null): ?><table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>状态</th>
                                        <th>ID</th>
                                        <th>名称</th>
                                        <th width="30%">操作</th>
                                    </tr>
                                <?php if(is_array($ArticleCateList)): foreach($ArticleCateList as $key=>$vo): ?><tr>
                                        <td class="text-center">
                                            <?php if($vo["status"] == 0): ?><span class="label label-danger usetype_<?php echo ($vo["id"]); ?>">不在使用</span><?php else: ?><span class="label label-primary usetype_<?php echo ($vo["id"]); ?>">正在使用</span><?php endif; ?>
                                        </td>
                                        <td class="text-center"><?php echo ($vo["id"]); ?></td>
                                        <td class="">
                                            <a <?php if($vo["level"] != 2): ?>href="<?php echo U('ArticleCate/ArticleCateList',array('pid'=>$vo['id']));?>"<?php endif; ?>><?php echo ($vo["cate_name"]); ?>
                                                <?php if($vo["level"] != 2): ?>(<?php echo ($vo["childNum"]); ?>)<?php endif; ?>
                                            </a>
                                            <br>
                                            <small>创建于 <?php echo ($vo["indate"]); ?></small>
                                        </td>
                                        <td class="">
                                            <?php if($vo["level"] != 2): ?><a href="<?php echo U('ArticleCate/ArticleCateList',array('pid'=>$vo['id']));?>" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看此分类下的小分类</a>
                                           <a class="btn btn-white btn-sm" href="<?php echo U('ArticleCate/addCate',array('pid'=>$vo['id']));?>">添加此广告位下的广告位</a><?php endif; ?>
                                            <a class="btn btn-white btn-sm" href="<?php echo U('updateInfo',array('id'=>$vo['id']));?>">编辑</a>

                                            <a class="btn btn-white btn-sm status show_<?php echo ($vo["id"]); ?>" data="<?php echo ($vo["id"]); ?>" status="<?php echo ($vo["status"]); ?>"><?php if($vo["status"] == 2): ?>使用<?php else: ?>禁用<?php endif; ?> </a>
                                        </td>
                                    </tr><?php endforeach; endif; ?>
                                </tbody>
                                </table>
                                <?php else: ?>
                                    <center>暂无数据~</center><?php endif; ?>
                                <div class="text-right">
                                    <div class="pagination"><?php echo ($page); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
   


    </div>
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        var refresh = function () {
            location.reload();  
        }
        // 操作分类的使用状态
        $('.status').on('click',function(){
            var this_  = $(this);
            var status = $(this).html();
            var id     = $(this).attr('data');
            var staVal  = $(this).attr('status');
            swal({
                title: "您确定要"+status+"这条信息吗",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: status,
                closeOnConfirm: false
            }, function () {
                $.post("<?php echo U('ArticleCate/updateSetStatus');?>",{id:id,status:staVal},function(msg){
                    console.log(msg);
                   if(msg == 1){
                        if(staVal == 1){
                            $('.show_'+id).html('使用');
                            $('.usetype_'+id).html('不在使用');
                            $('.usetype_'+id).css('background','#ED5565');
                            this_.attr('status','0');
                        }else{
                            $('.show_'+id).html('禁用');
                            $('.usetype_'+id).html('正在使用');
                            $('.usetype_'+id).css('background','#1AB394');
                            this_.attr('status','1');
                        }
                        
                   }
                })
                swal(status+"成功！", "", "success");
            });
        })
    </script>
</body>
</html>