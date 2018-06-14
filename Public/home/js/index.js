$(function() {
    $('.up').click(function () {
        $("html,body").animate({scrollTop:0},200);
    });

    // 返回顶部按钮的展示
    $(window).scroll(function () {
      sideBar();
    });
    sideBar();

    //返回顶部按钮的展示
    function sideBar() {
        var bodyHeight = $("body").height();
        winHeight = $(window).height();
        winScrollTop = $(document).scrollTop();
        if (winScrollTop >= bodyHeight - winHeight - 100) { //侧边栏定位
            $(".up").css("bottom", winHeight + winScrollTop + 120 - bodyHeight);
        } else {
            $(".up").css("bottom", "20px");
        }
        if (winScrollTop > 0) { //显示-隐藏滚动到顶部按钮
            $(".up").css('display', 'block');
        } else {
            $(".up").css('display', 'none');
        }
    }
});

