<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_PROTO,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (\Throwable $exception) {
            $request = request();

            if (! $request->isMethod('post') || ! $request->is('admin/login')) {
                return;
            }

            $previous = $exception->getPrevious();
            $pdoErrorInfo = $previous instanceof \PDOException ? $previous->errorInfo : null;
            $sqlState = is_array($pdoErrorInfo)
                ? ($pdoErrorInfo[0] ?? $previous->getCode())
                : null;
            $driverCode = is_array($pdoErrorInfo) ? ($pdoErrorInfo[1] ?? 'none') : 'none';
            $connection = $exception instanceof \Illuminate\Database\QueryException
                ? $exception->getConnectionName()
                : null;

            error_log(sprintf(
                'Admin login diagnostic: exception=%s code=%s sqlstate=%s driver_code=%s connection=%s file=%s line=%d',
                get_debug_type($exception),
                (string) $exception->getCode(),
                (string) ($sqlState ?? 'none'),
                (string) $driverCode,
                (string) ($connection ?? 'none'),
                basename($exception->getFile()),
                $exception->getLine(),
            ));

            return false;
        });
    })->create();
