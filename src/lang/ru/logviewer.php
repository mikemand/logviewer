<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => 'Вы уверены?',
            'body' => 'Вы действительно хотите удалить этот лог?',
            'btn' => array(
                'no' => 'Нет',
                'yes' => 'Да',
            )
        ),
        'error' => 'Ошибка во время удаления лога.',
        'success' => 'Лог удален успешно!',
        'btn' => 'Удалить Текущий Лог',
    ),
    'empty_file'  => 'Лог для :sapi на :date оказался пустым. Вы удаляли содержимое вручную?',
    'levels' => array(
        'all' => 'Все',
        'emergency' => 'Экстренная ошибка',
        'alert' => 'Тревога',
        'critical' => 'Критическая ошибка',
        'error' => 'Ошибка',
        'warning' => 'Предупреждение',
        'notice' => 'Уведомление',
        'info' => 'Информация',
        'debug' => 'Отладка',
    ),
    'no_log'  => 'Нет доступного лога для :sapi на :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 LogViewer',

);
