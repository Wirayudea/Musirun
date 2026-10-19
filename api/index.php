<?php

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
