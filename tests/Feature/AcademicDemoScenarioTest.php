<?php

namespace Tests\Feature;

use App\Academic\ScenarioRunner;
use Database\Seeders\AcademicDemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Billing\Entities\Invoice;
use Modules\Billing\Entities\Payment;
use Modules\Core\Entities\User;
use Tests\AcademicTestCase;

final class AcademicDemoScenarioTest extends AcademicTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AcademicDemoSeeder::class);
    }

    public function test_matching_evidence_creates_one_real_payment_and_pays_invoice(): void
    {
        $result = app(ScenarioRunner::class)->run('match');
        self::assertSame('validated', $result->status);
        self::assertSame(1, Payment::count());
        self::assertSame('paid', Invoice::findOrFail(1)->status);
    }

    public function test_seed_has_a_demo_only_evaluator_role_and_permissions(): void
    {
        self::assertSame('academic_evaluator', DB::table('roles')->value('name'));
        self::assertSame(2, DB::table('permissions')->where('name', 'like', 'demo.%')->count());
        self::assertSame(1, DB::table('model_has_roles')->where('model_id', 1)->count());
    }

    public function test_mismatched_amount_does_not_pay(): void
    {
        self::assertSame('observed', app(ScenarioRunner::class)->run('amount_mismatch')->status);
        self::assertSame(0, Payment::count());
        self::assertSame('pending', Invoice::findOrFail(2)->status);
    }

    public function test_mismatched_security_code_does_not_pay(): void
    {
        self::assertSame('observed', app(ScenarioRunner::class)->run('security_mismatch')->status);
        self::assertSame(0, Payment::count());
    }

    public function test_missing_receiver_waits_without_payment(): void
    {
        self::assertSame('waiting_receiver_event', app(ScenarioRunner::class)->run('missing_receiver')->status);
        self::assertSame(0, Payment::count());
    }

    public function test_replaying_the_same_intent_is_idempotent(): void
    {
        $runner = app(ScenarioRunner::class);
        $first = $runner->run('match');
        $second = $runner->run('match');
        self::assertSame($first->id, $second->id);
        self::assertSame($first->payment_id, $second->payment_id);
        self::assertSame(1, Payment::count());
        self::assertTrue((bool) $second->getAttribute('yape_reconciliation_already_completed'));
    }

    public function test_http_outbound_is_blocked(): void
    {
        $this->expectException(\RuntimeException::class);
        Http::get('https://never-contact.example');
    }

    public function test_demo_pages_require_authentication_and_operational_routes_are_absent(): void
    {
        $this->get('/demo/yape')->assertRedirect('/login');
        $this->post('/billing/openwa/webhook')->assertNotFound();
        $this->get('/network/routers/1/ssh')->assertNotFound();
        $this->actingAs(User::findOrFail(1))->get('/dashboard')->assertOk()->assertSee('Datos ficticios');
        foreach (['customers', 'contracts', 'invoices', 'payments'] as $page) {
            $this->get('/'.$page)->assertOk();
        }
        $this->post('/demo/yape', ['scenario' => 'match'])->assertRedirect('/demo/yape');
        self::assertSame(1, DB::table('payments')->count());
    }
}
