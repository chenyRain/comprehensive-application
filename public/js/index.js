$(function () {
    $.init();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 点赞
    $('.like').click(function () {
        var self = $(this);
        $.ajax({
            url: '/main/like',
            type: 'post',
            dataType: 'json',
            data: {'m_id' : self.attr('attr-mid')},
            success: function (back) {
                if (back.code == 1) {
                    self.addClass('already-like');
                    if ($.trim(self.find('.like-num').text()) == '') {
                        var like_num = 1;
                    } else {
                        var like_num = parseInt(self.find('.like-num').text()) + 1;
                    }
                    self.find('.like-num').text(like_num);
                } else {
                    $.toast(back.msg);
                    return false;
                }
            }
        });
    });
});