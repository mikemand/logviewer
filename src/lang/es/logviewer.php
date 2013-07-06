<?php

use Psr\Log\LogLevel;

return array(
    
    'delete' => array(
        'modal' => array(
            'header' => '¿Está seguro?',
            'body' => '¿Está seguro que desea eliminar este registro?',
            'btn' => array(
                'no' => 'No',
                'yes' => 'Sí',
            )
        ),
        'error' => 'Se ha producido un error al eliminar el registro.',
        'success' => 'Registro eliminado correctamente!',
        'btn' => 'Borrar el registro actual',
    ),
    'empty_file' => ':sapi registro de :date parece estar vacío. ¿Ha borrado manualmente el contenido?',
    'levels' => array(
        'all' => 'Todo',
        'emergency' => 'Emergency',
        'alert' => 'Alerta',
        'critical' => 'Crítico',
        'error' => 'Error',
        'warning' => 'Advertencia',
        'notice' => 'Aviso',
        'info' => 'Información',
        'debug' => 'Depuración',
    ),
    'no_log' => 'No :sapi registro disponibles para :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi' => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 LogViewer',
    
);
