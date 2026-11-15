<?php

namespace Tests\Unit;

use App\Academic\IsolationGuard;
use PHPUnit\Framework\TestCase;

final class AcademicDemoIsolationTest extends TestCase
{
    public function test_memory_database_is_allowed_only_for_tests(): void
    {
        self::assertSame(':memory:', IsolationGuard::assertDatabase(dirname(__DIR__, 2), 'sqlite', ':memory:', 'testing'));
        $this->expectException(\RuntimeException::class);
        IsolationGuard::assertDatabase(dirname(__DIR__, 2), 'sqlite', ':memory:', 'academic');
    }

    public function test_only_the_owned_database_file_is_allowed(): void
    {
        $root = dirname(__DIR__, 2);
        self::assertSame(str_replace('\\', '/', $root.'/database/academic.sqlite'), IsolationGuard::assertDatabase($root, 'sqlite', $root.'/database/academic.sqlite', 'academic'));
    }

    public function test_mysql_connections_are_refused(): void
    {
        $this->expectException(\RuntimeException::class);
        IsolationGuard::assertDatabase(dirname(__DIR__, 2), 'mysql', 'production', 'academic');
    }

    public function test_outside_database_paths_are_refused(): void
    {
        $this->expectException(\RuntimeException::class);
        IsolationGuard::assertDatabase(dirname(__DIR__, 2), 'sqlite', dirname(__DIR__, 3).'/database/production.sqlite', 'academic');
    }

    public function test_production_environment_is_refused(): void
    {
        $this->expectException(\RuntimeException::class);
        IsolationGuard::assertDatabase(dirname(__DIR__, 2), 'sqlite', ':memory:', 'production');
    }
}
