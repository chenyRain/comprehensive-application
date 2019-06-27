$(function () {
    $.init();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 注册
    $('.register').click(function () {
        $.showIndicator();
        var data = {
            'name': $('#name').val(),
            'password': $('#password').val(),
            'password_confirmation': $('#repassword').val()
        };
        if (data.name == '') {
            $.toast('用户名不能为空~');
            $.hideIndicator();
            return false;
        }
        if (data.name.length > 20) {
            $.toast('用户名不能超过20个字符~');
            $.hideIndicator();
            return false;
        }
        if (data.password == '') {
            $.toast('密码不能为空~');
            $.hideIndicator();
            return false;
        }
        if (data.password_confirmation == '') {
            $.toast('确认密码不能为空~');
            $.hideIndicator();
            return false;
        }
        if (data.password_confirmation !== data.password) {
            $.toast('2次密码不一致~');
            $.hideIndicator();
            return false;
        }

        $.ajax({
            url: '/register-store',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function (back) {
                $.hideIndicator();
                if (back.code == 200) {
                    $('.register').css("pointer-events", "none");
                    $.toast("注册成功,将前往登陆~");
                    setTimeout(function () {
                        window.location.href = '/login'
                    },1000);
                } else {
                    if (back.msg == '') {
                        $.toast("注册失败~");
                    } else {
                        $.toast(back.msg);
                    }
                    return false;
                }
            }
        });
    });

    // 登录
    $('.login').click(function () {
        $.showIndicator();
        var data = {
            'name': $('#name').val(),
            'password': $('#password').val()
        };
        if (data.name == '') {
            $.toast('用户名不能为空~');
            $.hideIndicator();
            return false;
        }
        if (data.password == '') {
            $.toast('密码不能为空~');
            $.hideIndicator();
            return false;
        }

        $.ajax({
            url: '/login-store',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function (back) {
                $.hideIndicator();
                if (back.code == 200) {
                    $('.login').css("pointer-events", "none");
                    $.toast("登陆成功,将前往首页~");
                    setTimeout(function () {
                        window.location.href = '/';
                    },1000);
                } else {
                    $.toast(back.msg);
                    return false;
                }
            }
        });
    });
});