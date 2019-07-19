$(function() {
    chat.init();

    $('.button-send').click(function () {
        chat.sendMsg();
    });

    $(document).keyup(function(event){
        if(event.keyCode === 13){
            chat.sendMsg();
        }
    });
});

var config = ws_server;

var chat = {
    data : {
        wsServer : null,
        lockReconnect: false, // 重连
        timer: null, // 重连定时器对象
        timeout: 30000, // 心跳检测时间
        timeoutObj: null, // 倒计时定时器对象
        msg: {
            type: 'CHAT',
            content: null
        }, // 消息
    },
    init : function() {
        var uid = $('.chat-content').attr('data-id');
        var type = $('.chat-content').attr('data-type');
        this.createWebsocket(uid, type);
        this.open();
        this.close();
        this.messages();
        this.error();
    },
    createWebsocket: function(uid, type) {
        try {
            this.data.wsServer = new WebSocket(config.server + '?type:' + type + '&uid:' + uid);
        } catch (e) {
            console.log('catch');
            this.reconnect(); // 连接关闭，重连
        }
    },
    open : function() {
        this.data.wsServer.onopen = function(evt) {
            chat.startHeartCheck(); // 启动心跳检测
        }
    },
    close : function() {
        this.data.wsServer.onclose = function(evt) {
            $.toast("进入聊天室失败");
            chat.reconnect(); // 连接关闭，重连
        }
    },
    // 重连
    reconnect: function() {
        console.log('正在执行重连');
        $.toast("socket连接断开，正在尝试重新建立连接...");
        if (this.data.lockReconnect) {
            return;
        }
        this.data.lockReconnect = true;
        clearTimeout(this.data.timer);
        this.data.timer = setTimeout(function () {
            chat.init();
            chat.data.lockReconnect = false;
        }, 5000);
    },
    // 重置倒计时
    resetTimeout: function() {
        console.log('正在重置倒计时');
        //接收成功一次推送，就将心跳检测的倒计时重置为30秒
        clearTimeout(this.data.timeoutObj);
        this.startHeartCheck();
    },
    // 开始检测心跳
    startHeartCheck: function() {
        console.log('开始检测心跳了');
        this.data.timeoutObj = setTimeout(function () {
            chat.data.msg.type = 'HEART_BEAT';
            chat.data.msg.content = 1;
            chat.data.wsServer.send(JSON.stringify(chat.data.msg));
            chat.data.msg.type = 'CHAT';
        }, this.data.timeout);
    },
    messages : function() {
        this.data.wsServer.onmessage = function (evt) {
            var data = JSON.parse(evt.data);
            switch (data.type) {
                case 'open':
                    chat.appendUser(data.list);
                    chat.notice(data.message);
                    break;
                case 'close':
                    chat.removeUser(data.list);
                    chat.notice(data.message);
                    break;
                case 'message':
                    chat.newMessage(data);
                    break;
            }
            chat.resetTimeout();
        };
    },
    error : function() {
        this.data.wsServer.onerror = function (evt, e) {
            console.log('Error occured: ' + evt.data);
            chat.reconnect(); // 连接错误，重连
        };
    },
    removeUser: function(list) {
        var html = '';
        $.each(list, function (key, value) {
            html += '<li class="chat-li"><a class="line-user" href="javascript:;">'+ value.name +'</a></li>';
        });
        $(".user-list").empty().append(html);
    },
    sendMsg : function() {

        var content = $('#input-say').val();
        if (content.length < 1) {
            $.toast('请输入内容');
            return false;
        }
        if (content.length > 30) {
            $.toast('发送内容不能超过30个字符~');
            return false;
        }
        $('#input-say').val('');
        this.data.msg.content = content;
        this.data.wsServer.send(JSON.stringify(this.data.msg));
    },
    newMessage : function(data) {
        var uid = $('.chat-content').attr('data-id');
        var user_my = '';
        if (uid == data.uid) {
            user_my = 'user-my';
        }
        var html = '<li class="chat-li '+ user_my +'"><p class="user-name">'+ data.name +'</p>'
            + '<p class="user-content">'+ data.message +'</p></li>';
        $('.chat-list').append(html);
        $('.chat-content').scrollTop($('.chat-list').height())
    },
    notice : function(msg) {
        $.toast(msg);
    },
    appendUser : function(list) {
        var html = '';
        $.each(list, function (key, value) {
            html += '<li class="chat-li"><a class="line-user" href="javascript:;">'+ value.name +'</a></li>';
        });
        $(".user-list").empty().append(html);
    }
};