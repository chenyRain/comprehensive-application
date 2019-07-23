<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2019/6/26
 * Time: 14:30
 */

return [
    /**
     * 设置redis点赞请求频率，单位S
     */
    'index_like_time' => 1800,

    /**
     * 设置redis点赞key
     */
    'index_like_key' => 'chat:like:',

    /**
     * 应用redis评论频率，单位S
     */
    'comment_frequency' => 5,

    /**
     * 设置应用redis评论key
     */
    'comment_key' => 'comment:key',

    /**
     * 敏感词文件路径
     */
    'word_file_path' => '../resources/sensitive/SensitiveWord.txt',
];