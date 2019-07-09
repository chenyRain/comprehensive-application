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

var config = {
    server : 'ws://192.168.10.248:5801'
};

var chat = {
    data : {
        wsServer : null,
        info : {}
    },
    init : function() {
        var uid = $('.chat-content').attr('data-id');
        this.data.wsServer = new WebSocket(config.server + '/' + uid);
        this.open();
        this.close();
        this.messages();
        this.error();
    },
    open : function() {
        this.data.wsServer.onopen = function(evt) {
            // $.toast("连接成功");
        }
    },
    close : function() {
        this.data.wsServer.onclose = function(evt) {
            $.toast("进入聊天室失败");
        }
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
        };
    },
    error : function() {
        this.data.wsServer.onerror = function (evt, e) {
            console.log('Error occured: ' + evt.data);
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
        this.data.wsServer.send(content);
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