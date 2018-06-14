<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章列表</title>
    <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
  
    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/Public/css/pagelist.css" rel="stylesheet">


    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">

    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet"><base target="_blank">
    <style>
        .mytipmsg{font-size: 16px;font-weight: bold;}
        .showCenter{
            text-align: center;
        }
        .lightBoxGallery img {
            margin: 5px;
            width: 160px;
        }
    </style>
</head>
<body>
<div class="wrapper wrapper-content animated fadeInRight height">
    <div class="row">
        <div class="ibox">
            <div class="ibox-title">
                <div class="text-muted small pull-right">
                    <a href="<?php echo U('addArticle');?>" class="btn btn-primary btn-sm btn-outline" data-toggle="tooltip" data-placement="top" title="" data-original-title="添加文章"><i class="fa fa-pencil"></i>添加文章</a>
                    <button class="btn btn-white btn-sm" onclick="refresh();" data-toggle="tooltip" data-original-title="刷新"><i class="fa fa-refresh"></i></button>
                </div>
                <h2>文章列表</h2>
            </div>
            <div class="ibox-content">
                <form action="<?php echo U('ArticleList');?>" method="post">
                    <div class="input-group">
                        <input type="text" placeholder="查找文章标题\文章描述\文章内容" class="input form-control" name="search_keyword">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn btn-primary"><i class="fa fa-search"></i> 搜索</button>
                            </span>
                    </div>
                </form>
                <div class="clients-list">
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive margin-top">
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                        <tr>
                                            <th>序号</th>
                                            <th>文章标题</th>
                                            <th>文章描述</th>
                                            <th>阅读/点赞</th>
                                            <th>分类</th>
                                            <th>文章封面图</th>
                                            <th>文章创建时间</th>
                                            <th>发布者</th>
                                            <th>发布者角色类型</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                        <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                                                <td class="col-lg-1 showCenter"><?php echo ($key+1); ?></td>
                                                <td class="showCenter"><?php echo ($v["art_name"]); ?></td>
                                                <td>
                                                    <span data-toggle="tooltip" title="<?php echo ($v["art_desc"]); ?>"><?php echo (msubstr($v["art_desc"],0,20)); ?></span>
                                                </td>
                                                <td class="showCenter"><?php echo ($v["look_num"]); ?>/<?php echo ($v["like_num"]); ?></td>
                                                <td class="showCenter"><?php echo ((isset($v["big_name"]) && ($v["big_name"] !== ""))?($v["big_name"]):'-'); ?>/<?php echo ((isset($v["sm_name"]) && ($v["sm_name"] !== ""))?($v["sm_name"]):'-'); ?></td>
                                                <td class="showCenter lightBoxGallery"><a href="<?php echo ($v["resp_pic"]); ?>" title="图片" data-gallery=""><span class="glyphicon glyphicon-picture" aria-hidden="true"></a></span></td>
                                                <td class="showCenter"><?php echo ($v["article_date"]); ?></td>
                                                <td class="showCenter">
                                                    <?php if(empty($v['username'])): ?><span class="label label-default">无</span>
                                                        <?php else: ?>
                                                        <span class="label label-info"><?php echo ($v["username"]); ?></span><?php endif; ?>
                                                </td>
                                                <td class="showCenter"><?php if($v["u_type"] == 1): ?>后台运营人员<?php else: ?>前台网名用户<?php endif; ?></td>
                                                <td class="showCenter">
                                                    <?php if($v['status'] == 1): ?><span class="label label-primary">有效</span>
                                                        <?php else: ?>
                                                        <span class="label label-danger">无效</span><?php endif; ?>
                                                </td>
                                            
                                                <td class="client-status showCenter">
                                                    <a href="<?php echo U('updateArticle',array('artid'=>$v['id']));?>" class="" data-toggle="tooltip" title="编辑">
                                                        <?php if($v['atype'] == 0): ?><i class="fa fa-edit fa-lg">
                                                                <?php else: ?>
                                                                <i class="fa fa-eye fa-lg"><?php endif; ?>
                                                        </i></a>
                                                    <a href="<?php echo U('deleteArticle',array('artid'=>$v['id']));?>" onclick="return confirm('确定删除吗?删除后将无法恢复')" class="text-danger" data-toggle="tooltip" title="删除"><i class="fa fa-trash-o fa-lg"></i></a>
                                                </td>
                                            </tr><?php endforeach; endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="blueimp-gallery" class="blueimp-gallery">
                                    <div class="slides"></div>
                                    <h3 class="title"></h3>
                                    <a class="prev">‹</a>
                                    <a class="next">›</a>
                                    <a class="close">×</a>
                                    <a class="play-pause"></a>
                                    <ol class="indicator"></ol>
                                </div>
                                <div class="pagination"><?php echo ($page); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/Public/js/jquery.min.js?v=2.1.4"></script>
<script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
<script src="/Public/js/content.min.js?v=1.0.0"></script>
<script src="/Public/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script>
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });
    refresh = function () {
        location.reload();
    }

</script>
</body>

</html>