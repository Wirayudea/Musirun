<?php

ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED);

$runtimeCacheDirectory = DIRECTORY_SEPARATOR === '\\'
    ? dirname(__DIR__).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'vercel-cache'
    : sys_get_temp_dir().DIRECTORY_SEPARATOR.'musirun-bootstrap-cache';

if (! is_dir($runtimeCacheDirectory) &&
    ! mkdir($runtimeCacheDirectory, 0775, true) &&
    ! is_dir($runtimeCacheDirectory)) {
    throw new RuntimeException('Unable to create the Vercel runtime cache directory.');
}

foreach ([
    'APP_CONFIG_CACHE' => 'config.php',
    'APP_EVENTS_CACHE' => 'events.php',
    'APP_PACKAGES_CACHE' => 'packages.php',
    'APP_ROUTES_CACHE' => 'routes.php',
    'APP_SERVICES_CACHE' => 'services.php',
    'VIEW_COMPILED_PATH' => 'views',
] as $name => $file) {
    $value = DIRECTORY_SEPARATOR === '\\'
        ? 'storage/framework/vercel-cache/'.$file
        : $runtimeCacheDirectory.DIRECTORY_SEPARATOR.$file;

    putenv("{$name}={$value}");
    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
}

putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

register_shutdown_function(static function (): void {
    $error = error_get_last();

    if ($error === null || ! in_array($error['type'], [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_USER_ERROR,
        E_RECOVERABLE_ERROR,
    ], true)) {
        return;
    }

    error_log(sprintf(
        'PHP fatal diagnostic: type=%d file=%s line=%d',
        $error['type'],
        $error['file'],
        $error['line'],
    ));
});

require __DIR__.'/../public/index.php';
