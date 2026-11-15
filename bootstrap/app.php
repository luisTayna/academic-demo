<?php
require __DIR__.'/safety.php';
$app = new Illuminate\Foundation\Application(dirname(__DIR__));
$app->useStoragePath(dirname(__DIR__).'/storage');
$app->singleton(Illuminate\Contracts\Http\Kernel::class, App\Academic\HttpKernel::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, App\Academic\ConsoleKernel::class);
$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, App\Exceptions\Handler::class);
return $app;
