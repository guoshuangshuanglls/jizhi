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
    <title>跳转提示</title>
    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <script src="/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
</head>

<body class="gray-bg">

<?php if(isset($message)) {?>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-hand-peace-o"></i> 成功！
                </div>
                <div class="panel-body">
                    <p><?php echo($message); ?></p>
                </div>
                <div class="panel-footer">
                    页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait" value="<?php echo($type);?>"><?php echo($waitSecond); ?></b>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else{?>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <i class="fa fa-warning"></i> 警告！
                </div>
                <div class="panel-body">
                    <p><?php echo($error); ?></p>
                </div>
                <div class="panel-footer">
                    页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait" value="<?php echo($type);?>"><?php echo($waitSecond); ?></b>
                </div>
            </div>
        </div>
    </div>
</div>    

<?php }?>




<script>
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var typeStatus = $('#wait').attr('value');
var interval = setInterval(function(){
    var time = --wait.innerHTML;
    if(time <= 0) {
        if(typeStatus == 1){
            location.href = href;
        }else if (typeStatus == 2){
            parent.location.href = href;
        }
        
        clearInterval(interval);
    };
}, 1000);
})();
</script>
</body>
</html>
