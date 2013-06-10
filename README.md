#Laravel 4 LogViewer

Easily view and delete Laravel's logs.

Inspiration from [Fire Log](https://github.com/dperrymorrow/Fire-Log) for CodeIgniter by [David Morrow](https://github.com/dperrymorrow) and [Larvel Log Viewer](https://github.com/ericbarnes/Laravel-Log-Viewer) for Laravel 3 by [Eric Barnes](https://github.com/ericbarnes)

<insert license info here>

##Installation

Add `kmd/logviewer` as a requirement to `composer.json`:

```javascript
{
    ...
    "require": {
        ...
        "kmd/logviewer": "dev-master"
        ...
    },
}
```

Until this package is ready to go up on Packagist, add the following after the `require` line:

```javascript
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/igorw/monolog"
        }
    ]
```

##Usage

By default, LogViewer will register itself a couple of routes:

 * `logviewer` -> Redirect to today's log, showing all levels.
 * `logviewer/$sapi/$date/delete` -> Delete log from `$sapi` (see: [php_sapi_name](http://php.net/manual/en/function.php-sapi-name.php)) on `$date` (`Y-m-d` format).
 * `logviewer/$sapi/$date/$level?` -> Show log from `$sapi` on `$date` with `$level` (if not supplied, defaults to all).

LogViewer also registers a filter (`logviewer.logs`) to aggregate all the logs in your `storage_path()/logs/` directory and share them with the `$logs` variable.

Future versions will allow you to specify the names of these routes and add your own filters to them (to, for example, require authentication before viewing and/or deleting logs).
