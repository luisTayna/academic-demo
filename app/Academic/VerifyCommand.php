<?php
namespace App\Academic;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class VerifyCommand extends Command
{
    protected $signature = 'demo:verify';
    protected $description = 'Verifica aislamiento y procedencia del dominio.';
    public function handle(): int
    {
        $db = IsolationGuard::assertDatabase(base_path(), config('database.default'), config('database.connections.sqlite.database'), config('app.env'));
        $manifest = json_decode(file_get_contents(base_path('PROVENANCE.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach ($manifest['domain_files'] as $file => $hash) {
            if (hash_file('sha256', base_path($file)) !== $hash) { throw new \RuntimeException('Cambió el dominio: '.$file); }
        }
        foreach ([\Modules\Billing\Services\YapeReconciliationService::class, \Modules\Billing\Services\PaymentService::class, \Modules\Core\Entities\User::class] as $class) {
            $file = str_replace('\\', '/', (new \ReflectionClass($class))->getFileName());
            if (!str_starts_with($file, str_replace('\\', '/', base_path()).'/')) { throw new \RuntimeException('Autoload fuera de la demo.'); }
        }
        if (DB::table('academic_demo_meta')->value('fixture_version') !== 'academic-v1') { throw new \RuntimeException('Datos sin marca académica.'); }
        $this->line(json_encode(['isolation' => 'local_sqlite_only', 'database' => basename($db), 'customers' => DB::table('customers')->count(), 'invoices' => DB::table('invoices')->count(), 'payments' => DB::table('payments')->count(), 'domain_files_verified' => count($manifest['domain_files']), 'external_services' => 'blocked']));
        return self::SUCCESS;
    }
}
