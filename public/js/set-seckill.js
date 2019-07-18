$(function () {
    $("#datetime-picker-start").datetimePicker({
        toolbarTemplate: '<header class="bar bar-nav">\
    <button class="button button-link pull-right close-picker">确定</button>\
    <h1 class="title">选择日期和时间</h1>\
    </header>'
    });

    $("#datetime-picker-end").datetimePicker({
        toolbarTemplate: '<header class="bar bar-nav">\
    <button class="button button-link pull-right close-picker">确定</button>\
    <h1 class="title">选择日期和时间</h1>\
    </header>'
    });


    $('.seckill-submit').click(function () {
        var data = {};
        data.redis_max_user = $('#redis-max-user').val();
        data.datetime_picker_start = $('#datetime-picker-start').val();
        data.datetime_picker_end = $('#datetime-picker-end').val();
        data.repertory = $('#repertory').val();
        data.status = $('#status').val();
        if (data.redis_max_user == '') {
            $.toast('请设置队列允许人数');
            return;
        }
        if (data.datetime_picker_start == '') {
            $.toast('请设置开始时间');
            return;
        }
        if (data.datetime_picker_end == '') {
            $.toast('请设置结束时间');
            return;
        }
        if (data.repertory == '') {
            $.toast('请设置库存');
            return;
        }
        console.log(data);
        // $.showIndicator();
        // $.ajax({
        //     url: '/seckill/start',
        //     type: 'post',
        //     dataType: 'json',
        //     data: data,
        //     success: function (data) {
        //         $.hideIndicator();
        //         $.toast(data.msg);
        //     }
        // });
    });
});