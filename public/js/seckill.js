$(function () {
    var start = false;
    $('.start-seckill').click(function () {
        $(this).hide();
        $('.seckilling').css('display', 'block');
        $('.at-once').removeClass('disabled');
        start = true;

        settime(); // 倒计时
    });

    var init_time = 10;
    // 倒计时
    function settime() {
        if (init_time == 0) {
            $('.seckilling').hide();
            $('.start-seckill').css('display', 'block');
            $('.at-once').addClass('disabled');
            init_time = 10;
            return;
        } else {
            $('.seckill-time').text(init_time);
            init_time--;
        }
        setTimeout(function() {
            settime()
        },1000)
    }
});