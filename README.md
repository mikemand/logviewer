#Laravel 4 LogViewer

Easily view and delete Laravel 4's logs.

Inspiration from [Fire Log](https://github.com/dperrymorrow/Fire-Log) for CodeIgniter by [David Morrow](https://github.com/dperrymorrow) and [Larvel Log Viewer](https://github.com/ericbarnes/Laravel-Log-Viewer) for Laravel 3 by [Eric Barnes](https://github.com/ericbarnes)

Created and maintained by Micheal Mand. Copyright &copy; 2013. Licensed under the [MIT license](LICENSE.md).

If anyone has any ideas on how to make this framework agnostic, please contact me or open a pull request.

##Demo

[View the demo here](http://logviewer.kmdwebdesigns.com/logviewer)

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

Add the provider to your `app/config/app.php`:

```php
'providers' => array(

    ...
    'Kmd\Logviewer\LogviewerServiceProvider',

),
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
 * `logviewer/$sapi/$date/delete` -> Delete log from `$sapi` (see: [php\_sapi\_name](http://php.net/manual/en/function.php-sapi-name.php)) on `$date` (`Y-m-d` format).
 * `logviewer/$sapi/$date/$level?` -> Show log from `$sapi` on `$date` with `$level` (if not supplied, defaults to all).

LogViewer also registers a filter (`logviewer.logs`) to aggregate all the logs in your `storage_path()/logs/` directory and share them with the `$logs` variable.

###Configuration

 * `base_url`: The URL LogViewer will be available on. You can have this nested (for example: `admin/logviewer`). Default: `logviewer`.
 * `filters`: Before and After filters to apply to the routes. We define no filters by default, as not everyone uses authentication or the same filter names.
   * `global`: Filters that affect the entirety of the logviewer. For example: `'global' => array('before' => 'auth'),` will apply the default Laravel `auth` filter to the logviewer, requiring a logged in user for all routes.
   * `view`: Filters that affect the viewing of log files.
   * `delete`: Filter that affect the deletion of log files.
 * `per_page`: The number of log messages to show per page via Pagination. Default: 10.