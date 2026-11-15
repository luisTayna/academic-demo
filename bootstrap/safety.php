<?php
// Must execute before Laravel, Dotenv, inherited caches or database connections.
require_once dirname(__DIR__).'/app/Academic/IsolationGuard.php';
$demoRoot = dirname(__DIR__);
$fileValues = [];
if (is_file($demoRoot.'/.env')) {
    foreach (file($demoRoot.'/.env', FILE_IGNORE_NEW_LINES) as $line) {
        if (preg_match('/^([A-Z_]+)=(.*)$/', trim($line), $match)) {
            $fileValues[$match[1]] = trim($match[2], "\"' ");
        }
    }
}
$readDemoValue = static fn (string $key, string $default = '') => (string) ($_ENV[$key] ?? (getenv($key) !== false ? getenv($key) : ($fileValues[$key] ?? $default)));
foreach (['DB_URL', 'DATABASE_URL', 'DB_HOST', 'DB_USERNAME', 'DB_PASSWORD', 'LARAVEL_STORAGE_PATH', 'APP_CONFIG_CACHE', 'APP_SERVICES_CACHE', 'APP_PACKAGES_CACHE', 'APP_ROUTES_CACHE', 'APP_EVENTS_CACHE', 'APP_BASE_PATH'] as $unsafeKey) {
    if ($readDemoValue($unsafeKey) !== '') {
        throw new RuntimeException('Configuración externa bloqueada: '.$unsafeKey);
    }
}
if (is_file($demoRoot.'/bootstrap/cache/config.php')) {
    throw new RuntimeException('Caché de configuración heredada bloqueada.');
}
App\Academic\IsolationGuard::assertDatabase($demoRoot, $readDemoValue('DB_CONNECTION', 'sqlite'), $readDemoValue('DB_DATABASE', 'database/academic.sqlite'), $readDemoValue('APP_ENV', 'academic'));
unset($fileValues, $readDemoValue, $unsafeKey);
