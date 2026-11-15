<?php
$database = App\Academic\IsolationGuard::assertDatabase(base_path(), (string) env('DB_CONNECTION', 'sqlite'), (string) env('DB_DATABASE', 'database/academic.sqlite'), (string) env('APP_ENV', 'academic'));
return ['default' => 'sqlite', 'connections' => ['sqlite' => ['driver' => 'sqlite', 'database' => $database, 'prefix' => '', 'foreign_key_constraints' => true]], 'migrations' => 'migrations'];
