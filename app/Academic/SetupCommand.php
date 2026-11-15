<?php
namespace App\Academic;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class SetupCommand extends Command
{
    protected $signature = 'demo:setup';
    protected $description = 'Prepara exclusivamente los datos SQLite ficticios.';
    public function handle(): int
    {
        $path = IsolationGuard::assertDatabase(base_path(), config('database.default'), config('database.connections.sqlite.database'), config('app.env'));
        if ($path === ':memory:') { throw new \RuntimeException('La preparación persistente no admite memoria.'); }
        if (!file_exists($path)) { touch($path); }
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        if ($tables && !Schema::hasTable('academic_demo_meta')) { throw new \RuntimeException('Base existente sin marca académica: no se modifica.'); }
        if (!$tables) {
            Artisan::call('migrate', ['--force' => true]);
            $this->output->write(Artisan::output());
        }
        (new \Database\Seeders\AcademicDemoSeeder())->run();
        $this->info('Demo preparada: datos ficticios y conexiones externas bloqueadas.');
        $this->line('Acceso local: evaluador@example.test / DemoAcademica2026!');
        return self::SUCCESS;
    }
}
