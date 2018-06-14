<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>运营系统平台 - 登录</title>
    <link rel="stylesheet" href="/Public/login/css/bootstrap.min.css">
    <link href="/Public/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public/login/css/font.css?vt=10">
    <link rel="stylesheet" href="/Public/login/css/form-elements.css?vt=0">
    <link rel="stylesheet" href="/Public/login/css/style.css?vt=0">

    <style>
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 50px #FFFFFF inset;
            -webkit-text-fill-color: #333;
        }

        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 50px #FFFFFF inset;
            -webkit-text-fill-color: #333;
        }
    </style>
    <script>if (window.top !== window.self) {
        window.top.location = window.location;
    }</script>
</head>

<body>
<!-- Top content -->
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1>
                        <!-- <img src="/Public/login/img/login.png" /> -->
                        <span>系统登录</span>
                    </h1>
                    <!--
                    <div class="description">
                        <p>
                            This is a free responsive login form made with Bootstrap.
                            Download it on <a href="http://azmind.com"><strong>AZMIND</strong></a>, customize and use it as you like!
                        </p>
                    </div>
                    -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>请您登录!</h3>
                            <p>在下面填写相关的登录信息，进行登录验证。</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" method="post" action="<?php echo U('loginMen');?>" class="login-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    <input type="text" name="username" required="" autocomplete="off" placeholder="用户名" class="form-username form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                    <input type="password" name="password" required=""  autocomplete="off" placeholder="密码" class="form-password form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-flag"></i></div>
                                            <input type="text" name="verify" required=""  autocomplete="off" placeholder="验证码" class="form-password form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="<?php echo U('Login/verify');?>" id="verify" style="cursor:pointer;border-radius: 3px;">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn">进入系统...</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 social-login">
                    <h3>&copy; 2017 系统平台</h3>
                </div>
            </div>
            <!--
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 social-login">
                    <h3>...or login with:</h3>
                    <div class="social-login-buttons">
                        <a class="btn btn-link-1 btn-link-1-facebook" href="#">
                            <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a class="btn btn-link-1 btn-link-1-twitter" href="#">
                            <i class="fa fa-twitter"></i> Twitter
                        </a>
                        <a class="btn btn-link-1 btn-link-1-google-plus" href="#">
                            <i class="fa fa-google-plus"></i> Google Plus
                        </a>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>

</div>


<script src="/Public/js/jquery.min.js?v=2.1.4"></script>
<script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
<script src="/Public/login/js/jquery.backstretch.min.js"></script>
<script src="/Public/login/js/scripts.js"></script>
<script>
    $('#verify').click(function () {
        $(this).attr('src', "<?php echo U('Login/verify');?>?v=" + Math.random())
    });
</script>
</body>
</html>