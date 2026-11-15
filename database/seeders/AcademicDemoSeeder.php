<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

final class AcademicDemoSeeder extends Seeder
{
    public function run(): void
    {
        \App\Academic\IsolationGuard::assertDatabase(base_path(), config('database.default'), config('database.connections.sqlite.database'), config('app.env'));
        if (Schema::hasTable('academic_demo_meta')) {
            if (DB::table('academic_demo_meta')->value('fixture_version') === 'academic-v1') {
                $this->ensureDemoRoles();
                return;
            }
            throw new \RuntimeException('Marca académica desconocida.');
        }
        if (DB::table('users')->exists() || DB::table('customers')->exists()) { throw new \RuntimeException('La carga ficticia requiere tablas vacías.'); }
        DB::transaction(function () {
            $time = '2026-08-10 10:00:00';
            DB::table('users')->insert(['id' => 1, 'username' => 'evaluador_demo', 'email' => 'evaluador@example.test', 'password' => Hash::make('DemoAcademica2026!'), 'status' => 'active', 'created_at' => $time, 'updated_at' => $time]);
            DB::table('services')->insert(['id' => 1, 'name' => 'Internet ficticio', 'service_type' => 'internet', 'technology' => 'fiber', 'created_at' => $time, 'updated_at' => $time]);
            DB::table('plans')->insert(['id' => 1, 'service_id' => 1, 'name' => 'Plan académico 65', 'price' => 65, 'upload_speed' => 100, 'download_speed' => 100, 'created_at' => $time, 'updated_at' => $time]);
            foreach (range(1, 4) as $id) {
                DB::table('customers')->insert(['id' => $id, 'customer_type' => 'individual', 'first_name' => 'Cliente ficticio', 'last_name' => sprintf('%02d', $id), 'identity_document' => 'DEMO000'.$id, 'email' => 'cliente'.$id.'@example.test', 'phone' => '155501000'.$id, 'active' => true, 'customer_status' => 'active', 'created_at' => $time, 'updated_at' => $time]);
                DB::table('contracts')->insert(['id' => $id, 'customer_id' => $id, 'plan_id' => 1, 'start_date' => '2026-08-01', 'status' => 'active', 'final_price' => 65, 'notes' => 'Contrato ficticio sin equipo conectado', 'created_at' => $time, 'updated_at' => $time]);
                DB::table('invoices')->insert(['id' => $id, 'contract_id' => $id, 'invoice_number' => 'DEMO-INV-000'.$id, 'amount' => 65, 'total_amount' => 65, 'issue_date' => '2026-08-01', 'due_date' => '2026-08-31', 'billing_period' => '2026-08', 'status' => 'pending', 'created_at' => $time, 'updated_at' => $time]);
            }
            Schema::create('academic_demo_meta', function (\Illuminate\Database\Schema\Blueprint $table) { $table->string('fixture_version')->primary(); });
            DB::table('academic_demo_meta')->insert(['fixture_version' => 'academic-v1']);
            $this->ensureDemoRoles();
        });
    }

    private function ensureDemoRoles(): void
    {
        $time = '2026-08-10 10:00:00';
        DB::table('roles')->insertOrIgnore(['name' => 'academic_evaluator', 'guard_name' => 'web', 'created_at' => $time, 'updated_at' => $time]);
        $roleId = DB::table('roles')->where('name', 'academic_evaluator')->where('guard_name', 'web')->value('id');
        foreach (['demo.view', 'demo.yape.run'] as $name) {
            DB::table('permissions')->insertOrIgnore(['name' => $name, 'guard_name' => 'web', 'created_at' => $time, 'updated_at' => $time]);
            $permissionId = DB::table('permissions')->where('name', $name)->where('guard_name', 'web')->value('id');
            DB::table('role_has_permissions')->insertOrIgnore(['role_id' => $roleId, 'permission_id' => $permissionId]);
        }
        DB::table('model_has_roles')->insertOrIgnore(['role_id' => $roleId, 'model_type' => \Modules\Core\Entities\User::class, 'model_id' => 1]);
    }
}
