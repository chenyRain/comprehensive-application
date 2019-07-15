$(function () {
    seckill.init();
    
    $('.start-activity').click(function () {
        seckill.data.wsServer.send('1');
    });
});

var config = ws_server;

var seckill = {
    data : {
        wsServer : null
    },
    init : function() {
        var uid = $('.content').attr('data-id');
        var type = $('.content').attr('data-type');
        this.data.wsServer = new WebSocket(config.server + '/type:' + type + '/uid:' + uid);
        this.close();
        this.messages();
    },
    close : function() {
        this.data.wsServer.onclose = function(evt) {
            $.toast("服务异常");
        }
    },
    messages : function() {
        this.data.wsServer.onmessage = function (evt) {
            var data = JSON.parse(evt.data);
            if (data.activity_going_time > 1) {
                seckill.startActivity(data.activity_going_time);
            }
            if (data.activity_in_time > 1) {
                seckill.inActivity(data.activity_in_time);
            }
            // 活动结束
            if (data.activity_going_time == 0 && data.activity_in_time == 0) {
                var is_super = $('.content').attr('data-super');
                if (is_super == '1') {
                    $('.card-content-inner').empty().append('<button class="button button-big button-fill button-danger at-once start-activity">开启活动</button>');
                } else {
                    $('.card-content-inner').empty().append('<button class="button disabled button-big button-fill button-danger at-once">活动尚未开启</button>');
                }
                $('.atonce-buy').addClass('disabled');
            }
        };
    },
    // 开启活动
    startActivity: function (time) {
        if ($('.card-content-inner').find('p').length > 0) {
            $('.activity-going').text(time);
        } else {
            $('.card-content-inner').empty().append('<p class="button button-big button-round seckilling">准备中，离开启还剩 <b class="seckill-time activity-going">'+ time +'</b> s</p>');
        }
    },
    // 活动中
    inActivity: function (time) {
        if ($('.seckill-time').hasClass('in-activity')) {
            $('.in-activity').text(time);
        } else {
            $('.card-content-inner').empty().append('<p class="button button-big button-round">活动进行中，距结束还有 <span class="seckill-time in-activity">'+ time +'</span> s</p>');
            $('.atonce-buy').removeClass('disabled');
        }
    }
};