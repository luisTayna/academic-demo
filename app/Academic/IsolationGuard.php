<?php
namespace App\Academic;

final class IsolationGuard
{
    public static function assertDatabase(string $root, string $connection, string $database, string $environment): string
    {
        $root = str_replace('\\', '/', realpath($root) ?: '');
        if ($root === '' || basename($root) !== 'academic-demo' || trim((string) @file_get_contents($root.'/ACADEMIC_DEMO_ONLY')) !== 'noretel-academic-only-v1') {
            throw new \RuntimeException('Carpeta sin autorización académica.');
        }
        if (!in_array($environment, ['academic', 'testing'], true) || $connection !== 'sqlite') {
            throw new \RuntimeException('Solo se admite SQLite en modo académico o de pruebas.');
        }
        if ($database === ':memory:' && $environment === 'testing') {
            return $database;
        }
        $expected = $root.'/database/academic.sqlite';
        $database = str_replace('\\', '/', $database);
        if ($database === 'database/academic.sqlite') {
            $database = $expected;
        }
        if ($database !== $expected || is_link($database) || realpath(dirname($database)) !== realpath($root.'/database')) {
            throw new \RuntimeException('Base fuera del archivo exclusivo de la demo.');
        }
        if (file_exists($database) && str_replace('\\', '/', (string) realpath($database)) !== $expected) {
            throw new \RuntimeException('Enlace de base de datos rechazado.');
        }
        return $expected;
    }
}
