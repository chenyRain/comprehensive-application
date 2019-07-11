$(function () {
    seckill.init();
});

var config = ws_server;

var seckill = {
    data : {
        wsServer : null
    },
    init : function() {
        this.data.wsServer = new WebSocket(config.server);
        this.messages();
    },
    messages : function() {
        this.data.wsServer.onmessage = function (evt) {
            var data = JSON.parse(evt.data);
            switch (data.type) {
                case 'start':
                    seckill.startActivity(data);
                    break;
            }
        };
    },
    // 开启活动
    startActivity: function () {
        $('.card-content-inner').empty().append('<p class="button button-big button-round">活动进行中，距结束还有 <span class="seckill-time in-activity">60</span> s</p>');
        $('.atonce-buy').removeClass('disabled');

        var in_activity_time = $('.in-activity').text();
        var in_activity_T = setInterval(function () {
            in_activity_time--;
            $('.in-activity').text(in_activity_time);
            if (in_activity_time < 1) {
                clearTimeout(in_activity_T);
                $('.card-content-inner').empty().append('<p class="button button-big button-round seckilling">准备中，离开启还剩 <b class="seckill-time activity-end">60</b> s</p>');
                $('.atonce-buy').addClass('disabled');
                seckill.endActivity();
            }
        }, 1000);
    },
    // 冷却中
    endActivity: function () {
        var activity_end_time = $('.activity-end').text();
        var activity_end_T = setInterval(function () {
            activity_end_time--;
            $('.activity-end').text(activity_end_time);
            if (activity_end_time < 1) {
                clearTimeout(activity_end_T);
                $('.card-content-inner').empty().append('<button class="button disabled button-big button-fill button-danger at-once">活动尚未开启</button>');
            }
        }, 1000);
    }
};