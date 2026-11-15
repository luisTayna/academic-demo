<?php
namespace App\Academic;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class AcademicDemoProvider extends ServiceProvider
{
    public function register(): void
    {
        $config = $this->app['config'];
        $config->set('mail', ['default' => 'array', 'mailers' => ['array' => ['transport' => 'array']], 'from' => ['address' => 'demo@example.test', 'name' => 'Demo']]);
        $config->set('queue', ['default' => 'sync', 'connections' => ['sync' => ['driver' => 'sync']]]);
        $config->set('broadcasting.default', 'null');
        $config->set('audit.enabled', false);
        $config->set('session.driver', $this->app->environment('testing') ? 'array' : 'file');
        $config->set('session.files', storage_path('framework/sessions'));
        $config->set('session.cookie', 'academic_demo_session');
        $config->set('session.domain', null);
        $config->set('session.secure', false);
        $config->set('cache.default', 'array');
        $config->set('logging.default', 'single');
        $config->set('logging.channels.single', ['driver' => 'single', 'path' => storage_path('logs/academic-demo.log'), 'level' => 'warning']);
        $config->set('filesystems.default', 'local');
        $config->set('filesystems.disks', ['local' => ['driver' => 'local', 'root' => storage_path('app')]]);
    }

    public function boot(): void
    {
        IsolationGuard::assertDatabase(base_path(), config('database.default'), config('database.connections.sqlite.database'), config('app.env'));
        Http::fake(static function () { throw new \RuntimeException('Conexiones HTTP externas bloqueadas en la demo.'); });
        Http::preventStrayRequests();
        $this->loadMigrationsFrom(array_merge([database_path('migrations')], glob(base_path('Modules/*/Database/Migrations'), GLOB_ONLYDIR)));
        Route::middleware('web')->group(base_path('routes/academic.php'));
    }
}
