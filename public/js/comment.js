$(function () {
    $.init();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 评论
    $('.comment-button').click(function () {
        var content = $('.comment-textarea').val();
        var m_id = $(this).attr('attr-id');

        if (content == '') {
            $.toast('请输入评论内容！');
            $.hideIndicator();
            return false;
        }
        if (content.length > 140) {
            $.toast('评论内容不能超过140个字！');
            $.hideIndicator();
            return false;
        }
        $(this).attr('disabled', 'disabled');
        $.ajax({
            url: '/comment/store',
            type: 'post',
            dataType: 'json',
            data: {'content' : content, 'm_id' : m_id},
            success: function (back) {
                if (back.code == 1) {
                    var html = '<li>\n' +
                        '            <div class="item-inner">\n' +
                        '                    <div class="item-title-row">\n' +
                        '                        <div class="item-title comment-username">'+ back.result.nickname +'</div>\n' +
                        '                        <div class="item-after time-color">' + back.result.ctime + '</div>\n' +
                        '                    </div>\n' +
                        '                    <div class="item-text comment-content">' + back.result.content + '</div>\n' +
                        '                </div>\n' +
                        '        </li>';

                    $('.comment-list').children("li:first-child").before(html);
                    $('.comment-textarea').val('');
                    $('.comment-button').removeAttr('disabled');
                    $.toast(back.msg);
                } else {
                    $.toast(back.msg);
                    return false;
                }
            }
        });
    });

    // 下拉分页评论列表
    var loading = false;
    var page = 1; // 分页数
    $(document).on('infinite', '.infinite-scroll-bottom',function() {
        // 如果正在加载，则退出
        if (loading) return;
        // 设置flag
        loading = true;
        page++; // 分页数
        var m_id = $('.comment-button').attr('attr-id'); // 应用ID
        $('.infinite-scroll-preloader').empty().append('<div class="preloader"></div>'); // 加载图标

        $.ajax({
            url: '/comment/index',
            dataType: 'json',
            data: {'page' : page, 'm_id' : m_id},
            success: function (back) {
                if (back.code == 1) {
                    if (back.result == '') {
                        // 加载完毕，则注销无限加载事件，以防不必要的加载
                        $.detachInfiniteScroll($('.infinite-scroll'));
                        // 删除加载提示符
                        $('.infinite-scroll-preloader').remove();
                        $('.page-bottom').html('-- 我是有底线的 --');
                        return;
                    }
                    var html = '';
                    $.each(back.result, function (i, n) {
                        html += '<li>\n' +
                            '            <div class="item-inner">\n' +
                            '                    <div class="item-title-row">\n' +
                            '                        <div class="item-title comment-username">'+ n.name +'</div>\n' +
                            '                        <div class="item-after time-color">' + n.ctime + '</div>\n' +
                            '                    </div>\n' +
                            '                    <div class="item-text comment-content">' + n.content + '</div>\n' +
                            '                </div>\n' +
                            '        </li>';
                    });
                    $('.comment-list').append(html);
                    loading = false;
                } else {
                    $.toast(back.msg);
                    return false;
                }
            }
        });
    });
});