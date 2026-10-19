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
            $driverMessage = is_array($pdoErrorInfo) ? ($pdoErrorInfo[2] ?? '') : '';
            $sqlState = is_array($pdoErrorInfo)
                ? ($pdoErrorInfo[0] ?? $previous->getCode())
                : null;
            $driverCode = is_array($pdoErrorInfo) ? ($pdoErrorInfo[1] ?? 'none') : 'none';
            $previousMessage = strtolower(($previous?->getMessage() ?? '').' '.$driverMessage);
            $failureCategory = match (true) {
                str_contains($previousMessage, 'password authentication failed') => 'database_authentication_rejected',
                str_contains($previousMessage, 'no pg_hba.conf entry') => 'database_access_rule_rejected',
                str_contains($previousMessage, 'too many clients') => 'database_connection_limit',
                str_contains($previousMessage, 'could not translate host name') => 'database_dns_failure',
                str_contains($previousMessage, 'connection refused') => 'database_connection_refused',
                str_contains($previousMessage, 'timeout') => 'database_connection_timeout',
                str_contains($previousMessage, 'ssl') => 'database_tls_failure',
                str_contains($previousMessage, 'server closed') || str_contains($previousMessage, 'reset by peer') => 'database_connection_closed',
                str_contains($previousMessage, 'could not connect') => 'database_unreachable',
                default => 'database_error_unclassified',
            };
            $connection = $exception instanceof \Illuminate\Database\QueryException
                ? $exception->getConnectionName()
                : null;

            error_log(sprintf(
                'Admin login diagnostic: exception=%s code=%s sqlstate=%s driver_code=%s category=%s connection=%s file=%s line=%d',
                get_debug_type($exception),
                (string) $exception->getCode(),
                (string) ($sqlState ?? 'none'),
                (string) $driverCode,
                $failureCategory,
                (string) ($connection ?? 'none'),
                basename($exception->getFile()),
                $exception->getLine(),
            ));

            return false;
        });
    })->create();
