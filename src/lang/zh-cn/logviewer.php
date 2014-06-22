<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => '你确定?',
            'body' => '你确定要删除这些日志吗?',
            'btn' => array(
                'no' => '否',
                'yes' => '是',
            )
        ),
        'error' => '删除日志时发生错误.',
        'success' => '删除日志成功!',
        'btn' => '删除当前日志',
    ),
    'empty_file'  => ':date 的 :sapi 日记是空的。您是否手动删除了这些内容?',
    'levels' => array(
        'all' => '全部',
        'emergency' => '紧急',
        'alert' => '警示',
        'critical' => '严重',
        'error' => '错误',
        'warning' => '警告',
        'notice' => '注意',
        'info' => '信息',
        'debug' => '调试',
    ),
    'no_log'  => ':date 沒有 :sapi 的日志',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 日志查看器',

);
