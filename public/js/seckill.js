var startTime = $('.content').attr('data-start'); // 开始时间
var endTime = $('.content').attr('data-end'); // 结束时间
var status = $('.content').attr('data-status'); // 活动状态 1=开启
var objStartDate = new Date(startTime); // 开始时间对象
var objEndDate = new Date(endTime); // 结束时间对象
var startMillisecond = objStartDate.getTime(); // 开始时间毫秒数
var endMillisecond = objEndDate.getTime(); // 结束时间毫秒数
var objNowDate = new Date(); // 当前时间对象
var nowTime = objNowDate.getTime(); // 当前时间毫秒数 1563250292561
var windType = 1; // 1=开始，2=进行中

$(function () {
    // 活动未开始倒计时
    if (nowTime < startMillisecond) {
        run();
    }
    // 活动进行中倒计时
    if (nowTime >= startMillisecond && nowTime < endMillisecond) {
        windType = 2;
        run();
    }
    // 活动已结束
    if (nowTime > endMillisecond || status == 0) {
        $('.card-content-inner').empty().append('<button class="button disabled button-big button-fill button-danger at-once">活动尚未开启</button>');
        $('.atonce-buy').addClass('disabled');
    }
});


/**
 * 运行定时器
 * @param Date
 * @param type
 */
var Timer;
function run() {
     Timer = setInterval(function(){
        getDate();
    }, 1000);
}

/**
 * 计算倒计时时间
 * @param activityDate
 * @param type
 */
function getDate() {
    var objNowDate = new Date(); // 当前时间对象
    var nowTime = objNowDate.getTime(); // 当前时间毫秒数 1563250292561
    var activityDate;

    if (windType == 1) {
        if ((startMillisecond - nowTime) < 1000) {
            windType = 2;
        }
        activityDate = startMillisecond;
    } else {
        if ((endMillisecond - nowTime) < 1000) {
            clearInterval(Timer);
            $('.card-content-inner').empty().append('<button class="button disabled button-big button-fill button-danger at-once">活动尚未开启</button>');
            $('.atonce-buy').addClass('disabled');
            return;
        }
        activityDate = endMillisecond;
    }

    var second = Math.floor((activityDate - nowTime) / 1000); // 开始时间距离现在的秒数
    var day = Math.floor(second / (24 * 60 * 60)); //整数部分代表的是天；一天有24*60*60=86400秒;
    second = second % 86400; //余数代表剩下的秒数
    var hour = Math.floor(second / 3600); //整数部分代表小时
    second %= 3600; //余数代表 剩下的秒数；
    var minute = Math.floor(second / 60); // 整数部分代表分钟
    second %= 60; //余数代表 剩下的秒数
    var is_p = $('.card-content-inner').find('p').length;

    if (windType == 1) {
        if (is_p > 0) {
            if (! $('.card-content-inner p').hasClass('seckilling')) {
                var startHtml = '<p class="button button-big button-round seckilling">准备中，离开启 ' +
                    '<b class="seckill-time hour">'+ hour +'</b> ：' +
                    '<b class="seckill-time minute">'+ minute +'</b> ：' +
                    '<b class="seckill-time second">'+ second +'</b>' +
                    '</p>';
                $('.card-content-inner').empty().append(startHtml);
            }
        } else {
            var startHtml = '<p class="button button-big button-round seckilling">准备中，离开启 ' +
                '<b class="seckill-time hour">'+ hour +'</b> ：' +
                '<b class="seckill-time minute">'+ minute +'</b> ：' +
                '<b class="seckill-time second">'+ second +'</b>' +
                '</p>';
            $('.card-content-inner').empty().append(startHtml);
        }
    } else {
        if (is_p > 0) {
            if (! $('.card-content-inner p').hasClass('in-activity')) {
                var endHtml = '<p class="button button-big button-round in-activity">进行中，距结束 ' +
                    '<b class="seckill-time hour">'+ hour +'</b> ：' +
                    '<b class="seckill-time minute">'+ minute +'</b> ：' +
                    '<b class="seckill-time second">'+ second +'</b>' +
                    '</p>';
                $('.card-content-inner').empty().append(endHtml);
                $('.atonce-buy').removeClass('disabled');
            }
        } else {
            var endHtml = '<p class="button button-big button-round in-activity">进行中，距结束 ' +
                '<b class="seckill-time hour">'+ hour +'</b> ：' +
                '<b class="seckill-time minute">'+ minute +'</b> ：' +
                '<b class="seckill-time second">'+ second +'</b>' +
                '</p>';
            $('.card-content-inner').empty().append(endHtml);
            $('.atonce-buy').removeClass('disabled');
        }

    }
    $('.hour').text(replenishTwo(hour));
    $('.minute').text(replenishTwo(minute));
    $('.second').text(replenishTwo(second));
}

/**
 * 个位数补充前置0
 * @param n
 * @returns {string}
 */
function replenishTwo(n) {
    return n >= 0 && n < 10 ? '0' + n : '' + n;
}