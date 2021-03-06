<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>运营系统</title>
    <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <link href="/Public/css/pagelist.css" rel="stylesheet">
    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/echarts.min.js"></script>
    <style>
        .mytipmsg{font-size: 16px;font-weight: bold;}
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right"><i class="fa fa-user"></i></span>
                    <h5>欢迎您当前用户</h5>
                </div>
                <div class="ibox-content">
                    <h5 class="no-margins"><?php echo ($uname); ?></h5>
                </div>
            </div>
        </div>        
    </div>
    <?php if($showStatus == 1): ?><div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5></h5>
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs btn-white">年</button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content" style="height: 450px;">
                        <div class="row">

                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <div id="main" style="width: 900px;height:350px;margin-left:25%;margin-bottom: 30px"></div>
                            </div>
                        
                        </div>
                    </div>

                </div>
            </div>
        </div><?php endif; ?>

        <script>
        var config = {"clientID":"6294","projectID":"8734","gbookStyle":"1","helper":"1","seat":"0","custid":"0","smallNum":"0","tq_seat":"0","activeStatus":"0","showtel400":"4008106218-0","seat2014":"0","custid2014":"0","smallNum2014":"0"};
        var gridsumdissector_rnd = Math.floor(Math.random()*100000);
        var customHostName = location.host.replace(/\./g,"");
        var tq_clientid   = 1;
        var tqUserDefined = {inviterHideByScroll:6300};
        </script>
        <script src="/static/js/gbook.js"></script>
        <div class="row">
            <div>
                <a name="notegbook" id="notegbook"></a>
            </div>
        </div>


</div>


<script src="/static/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script>
    var refresh = function () {
        location.reload();  
    }
</script>
<script type="text/javascript">
    // // 基于准备好的dom，初始化echarts实例
    // var myChart = echarts.init(document.getElementById('main'));
    // // 获取值
    // var data = $keys;

    // // 指定图表的配置项和数据
    // option = {

    //     color: ['#A3E1D4'],
    //     title: {
    //         text: '项目添加个数统计'
    //     },
    //     tooltip : {
    //         trigger: 'axis',
    //         axisPointer : {            // 坐标轴指示器，坐标轴触发有效
    //             type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
    //         }
    //     },
    //     grid: {
    //         left: '3%',
    //         right: '4%',
    //         bottom: '3%',
    //         containLabel: true
    //     },
    //     xAxis : [
    //         {
    //             type : 'category',
    //             data : ['1月', '2月', '3月', '4月', '5月', '6月', '7月','8月','9月','10月','11月','12月'],
    //             axisTick: {
    //                 alignWithLabel: true
    //             }
    //         }
    //     ],
    //     yAxis : [
    //         {
    //             type : 'value'
    //         }
    //     ],
    //     series : [
    //         {
    //             name:'添加个数',
    //             type:'bar',
    //             barWidth: '60%',
    //             data:data
    //         }
    //     ]
    // };



    // // 使用刚指定的配置项和数据显示图表。
    // myChart.setOption(option);
</script>
</body>
</html>