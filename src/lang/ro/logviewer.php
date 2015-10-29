<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => 'Ești sigur(ă)?',
            'body' => 'Ești sigur(ă) ca vrei să ștergi acest jurnal?',
            'btn' => array(
                'no' => 'Nu',
                'yes' => 'Da',
            )
        ),
        'error' => 'A apărut o eroare la ștergerea jurnalului.',
        'success' => 'Jurnalul a fost șters cu succes!',
        'btn' => 'Șterge jurnal curent',
    ),
    'empty_file'  => 'Jurnalul :sapi pentru data de :date este gol. Ați șters conținutul manual?',
    'levels' => array(
        'all' => 'toate',
        'emergency' => 'urgență',
        'alert' => 'alertă',
        'critical' => 'critică',
        'error' => 'eroare',
        'warning' => 'avertisment',
        'notice' => 'aviz',
        'info' => 'informare',
        'debug' => 'depanare',
    ),
    'no_log'  => 'Jurnal :sapi inexistent pentru data de :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 LogViewer',

);
