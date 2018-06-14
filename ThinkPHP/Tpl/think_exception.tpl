<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>发生错误啦，小伙伴正在抢修...</title>
	<link rel="shortcut icon" href="favicon.ico"> 
    <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <script src="/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
</head>
<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <i class="fa fa-warning"></i> 发生错误啦，小伙伴正在抢修...
                </div>
                <div class="panel-body">
                	<h1><?php echo strip_tags($e['message']);?></h1>
                    <div class="content">
						<?php if(isset($e['file'])) {?>
						    <div class="info">
						        <div class="title">
						            <h3>错误位置</h3>
						        </div>
						        <div class="text">
						            <p>FILE: <?php echo $e['file'] ;?> &#12288;LINE: <?php echo $e['line'];?></p>
						        </div>
						    </div>
						<?php }?>
						<?php if(isset($e['trace'])) {?>
						    <div class="info">
						        <div class="title">
						            <h3>TRACE</h3>
						        </div>
						        <div class="text">
						            <p><?php echo nl2br($e['trace']);?></p>
						        </div>
						    </div>
						<?php }?>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>  

</body>
</html>
