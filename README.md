#Laravel 4 LogViewer

Easily view and delete Laravel 4's logs.

Inspiration from [Fire Log](https://github.com/dperrymorrow/Fire-Log) for CodeIgniter by [David Morrow](https://github.com/dperrymorrow) and [Larvel Log Viewer](https://github.com/ericbarnes/Laravel-Log-Viewer) for Laravel 3 by [Eric Barnes](https://github.com/ericbarnes)

Created and maintained by Micheal Mand. Copyright &copy; 2013. Licensed under the [MIT license](LICENSE.md).

If anyone has any ideas on how to make this framework agnostic, please contact me or open a pull request.

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

Update composer:

```
$ php composer.phar update
```

Publish package assets:

```
$ php artisan asset:publish kmd/logviewer
```

(Optional) Publish package config:

```
$ php artisan config:publish kmd/logviewer
```

##Usage and Configuration

###Usage

By default, LogViewer will register itself a couple of routes:

 * `logviewer` -> Redirect to today's log, showing all levels.
 * `logviewer/$sapi/$date/delete` -> Delete log from `$sapi` (see: [php_sapi_name](http://php.net/manual/en/function.php-sapi-name.php)) on `$date` (`Y-m-d` format).
 * `logviewer/$sapi/$date/$level?` -> Show log from `$sapi` on `$date` with `$level` (if not supplied, defaults to all).

LogViewer also registers a filter (`logviewer.logs`) to aggregate all the logs in your `storage_path()/logs/` directory and share them with the `$logs` variable.

###Configuration

 * `per_page`: The number of log messages to show per page via Pagination. Default: 10.

##TODO, Upcoming, etc.

 * Need to finish setting up the highlights for all log levels.
 * Allow users to specify the names of the routes and add their own filters to them (to, for example, require authentication before viewing and/or deleting logs).