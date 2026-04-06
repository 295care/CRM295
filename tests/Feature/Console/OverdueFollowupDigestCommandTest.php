<?php

namespace Tests\Feature\Console;

use App\Models\Activity;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OverdueFollowupDigestCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_overdue_digest_command_outputs_sales_summary(): void
    {
        config(['services.crm.followup_webhook_url' => 'https://example.test/webhook/crm']);
        Mail::fake();
        Http::fake();

        $sales = User::factory()->create([
            'name' => 'Sales Digest',
            'email' => 'digest@example.test',
        ]);

        $lead = Lead::create([
            'nama_client' => 'Lead Digest',
            'perusahaan' => 'PT Digest',
            'no_hp' => '0888888888',
            'email' => 'lead-digest@example.test',
            'alamat' => 'Jakarta',
            'sumber_lead' => 'website',
            'status' => 'Warm',
            'assigned_to' => $sales->id,
            'notes' => null,
        ]);

        Activity::create([
            'lead_id' => $lead->id,
            'tanggal' => now()->subDays(2)->toDateString(),
            'jenis' => 'call',
            'catatan' => 'Follow up belum berhasil',
            'next_follow_up' => now()->subDay(),
        ]);

        $this->artisan('crm:followups:overdue-digest')
            ->expectsOutputToContain('Sales Digest: 1 overdue follow-up')
            ->assertExitCode(0);

        Http::assertSent(function ($request): bool {
            return $request->url() === 'https://example.test/webhook/crm'
                && $request['type'] === 'overdue_followup_digest'
                && $request['overdue_count'] === 1
                && $request['sales']['name'] === 'Sales Digest';
        });
    }

    public function test_overdue_digest_command_handles_empty_data(): void
    {
        $this->artisan('crm:followups:overdue-digest')
            ->expectsOutput('Tidak ada overdue follow-up.')
            ->assertExitCode(0);
    }

    public function test_overdue_digest_command_logs_warning_when_webhook_fails(): void
    {
        config(['services.crm.followup_webhook_url' => 'https://example.test/webhook/crm']);
        Mail::fake();
        Log::spy();

        Http::fake([
            'https://example.test/webhook/crm' => Http::response(['error' => 'failed'], 500),
        ]);

        $sales = User::factory()->create([
            'name' => 'Sales Digest',
            'email' => 'digest@example.test',
        ]);

        $lead = Lead::create([
            'nama_client' => 'Lead Digest',
            'perusahaan' => 'PT Digest',
            'no_hp' => '0888888888',
            'email' => 'lead-digest@example.test',
            'alamat' => 'Jakarta',
            'sumber_lead' => 'website',
            'status' => 'Warm',
            'assigned_to' => $sales->id,
            'notes' => null,
        ]);

        Activity::create([
            'lead_id' => $lead->id,
            'tanggal' => now()->subDays(2)->toDateString(),
            'jenis' => 'call',
            'catatan' => 'Follow up belum berhasil',
            'next_follow_up' => now()->subDay(),
        ]);

        $this->artisan('crm:followups:overdue-digest')
            ->expectsOutputToContain('Webhook gagal untuk Sales Digest')
            ->assertExitCode(0);

        Log::shouldHaveReceived('warning')
            ->once()
            ->withArgs(function (string $message, array $context): bool {
                return $message === 'CRM overdue webhook dispatch failed'
                    && isset($context['sales_id'])
                    && ! empty($context['error']);
            });
    }
}
