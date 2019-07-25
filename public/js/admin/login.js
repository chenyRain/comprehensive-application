layui.use(['form', 'layer'], function() {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.$;

    //自定义验证规则
    form.verify({
        username: function(value) {
            if(value.length < 1) {
                return '用户名不能为空';
            }
            if(value.length > 20) {
                return '用户名不能超过20个字符';
            }
        },
        password: [/(.+){6,12}$/, '密码必须6到18位'],
        captcha: [/(.+){4}$/, '验证码必须是4位']
    });

    $('.verifyImg').click(function () {
        $(this).attr('src', '/admin/getCaptcha?s=' + Math.random());
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 执行登录
    form.on('submit(login)', function(data){
        var load = layer.load(0);
        $.ajax({
            url: '/admin/login-store',
            type: 'post',
            dataType: 'json',
            data: data.field,
            success: function (back) {
                layer.close(load);
                if (back.code == 1) {
                    layer.msg(back.msg, {icon: 6});
                    setTimeout(function () {
                        window.location.href = '/admin';
                    },1000);
                } else {
                    layer.msg(back.msg, {icon: 5});
                }
            }
        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
});