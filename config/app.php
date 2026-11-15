<?php
return [
 'name' => 'Noretel Demo académica', 'env' => env('APP_ENV', 'academic'), 'debug' => false,
 'url' => 'http://127.0.0.1:8091', 'timezone' => 'America/Lima', 'locale' => 'es', 'fallback_locale' => 'en',
 'key' => env('APP_KEY', 'base64:'.base64_encode(str_repeat('A', 32))), 'cipher' => 'AES-256-CBC',
 'providers' => Illuminate\Support\ServiceProvider::defaultProviders()->merge([App\Academic\AcademicDemoProvider::class])->toArray(),
 'aliases' => Illuminate\Support\Facades\Facade::defaultAliases()->toArray(),
];
