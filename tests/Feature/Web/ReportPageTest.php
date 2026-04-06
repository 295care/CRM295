<?php

namespace Tests\Feature\Web;

use App\Models\Lead;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_page_renders_successfully(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $lead = Lead::create([
            'nama_client' => 'Client Report',
            'perusahaan' => 'PT Report',
            'no_hp' => '08120000000',
            'email' => 'report@example.test',
            'alamat' => 'Jakarta',
            'sumber_lead' => 'website',
            'status' => 'Deal',
            'assigned_to' => $user->id,
            'notes' => null,
        ]);

        Quotation::create([
            'lead_id' => $lead->id,
            'tanggal_penawaran' => now()->toDateString(),
            'nomor_penawaran' => 'RPT-001',
            'nilai_penawaran' => 1000000,
            'status' => 'accepted',
            'keterangan' => 'ok',
        ]);

        $response = $this->get('/reports?year='.now()->year);

        $response->assertOk();
        $response->assertSee('Reporting Center');
        $response->assertSee('Client Report');
    }

    public function test_report_export_downloads_csv(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Lead::create([
            'nama_client' => 'Client Export',
            'perusahaan' => 'PT Export',
            'no_hp' => '0812333444',
            'email' => 'export@example.test',
            'alamat' => 'Bandung',
            'sumber_lead' => 'referensi',
            'status' => 'Hot',
            'assigned_to' => $user->id,
            'notes' => null,
        ]);

        $year = now()->year;

        $response = $this->get('/reports/export?year='.$year);

        $response->assertOk();
        $response->assertDownload("crm-report-{$year}.csv");
    }

    public function test_report_page_status_filter_limits_client_rows(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Lead::create([
            'nama_client' => 'Client Deal',
            'perusahaan' => 'PT Deal',
            'no_hp' => '0811111111',
            'email' => 'deal@example.test',
            'alamat' => 'Jakarta',
            'sumber_lead' => 'website',
            'status' => 'Deal',
            'assigned_to' => $user->id,
            'notes' => null,
        ]);

        Lead::create([
            'nama_client' => 'Client Hot',
            'perusahaan' => 'PT Hot',
            'no_hp' => '0822222222',
            'email' => 'hot@example.test',
            'alamat' => 'Bandung',
            'sumber_lead' => 'ig',
            'status' => 'Hot',
            'assigned_to' => $user->id,
            'notes' => null,
        ]);

        $response = $this->get('/reports?year='.now()->year.'&status=Deal');

        $response->assertOk();
        $response->assertSee('Client Deal');
        $response->assertDontSee('Client Hot');
    }

    public function test_report_page_date_range_filter_limits_rows(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $inRangeLead = Lead::create([
            'nama_client' => 'Client In Range',
            'perusahaan' => 'PT In Range',
            'no_hp' => '0833333333',
            'email' => 'inrange@example.test',
            'alamat' => 'Jakarta',
            'sumber_lead' => 'website',
            'status' => 'Warm',
            'assigned_to' => $user->id,
            'notes' => null,
        ]);
        $inRangeLead->timestamps = false;
        $inRangeLead->created_at = now()->subDays(3);
        $inRangeLead->updated_at = now()->subDays(3);
        $inRangeLead->save();

        $outRangeLead = Lead::create([
            'nama_client' => 'Client Out Range',
            'perusahaan' => 'PT Out Range',
            'no_hp' => '0844444444',
            'email' => 'outrange@example.test',
            'alamat' => 'Bandung',
            'sumber_lead' => 'ig',
            'status' => 'Warm',
            'assigned_to' => $user->id,
            'notes' => null,
        ]);
        $outRangeLead->timestamps = false;
        $outRangeLead->created_at = now()->subDays(45);
        $outRangeLead->updated_at = now()->subDays(45);
        $outRangeLead->save();

        $response = $this->get('/reports?year='.now()->year.'&from_date='.now()->subDays(7)->toDateString().'&to_date='.now()->toDateString());

        $response->assertOk();
        $response->assertSee('Client In Range');
        $response->assertDontSee('Client Out Range');
    }

    public function test_report_export_sales_monthly_downloads_csv(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Lead::create([
            'nama_client' => 'Client Monthly',
            'perusahaan' => 'PT Monthly',
            'no_hp' => '0855555555',
            'email' => 'monthly@example.test',
            'alamat' => 'Surabaya',
            'sumber_lead' => 'referensi',
            'status' => 'Deal',
            'assigned_to' => $user->id,
            'notes' => null,
        ]);

        $year = now()->year;

        $response = $this->get('/reports/export-sales-monthly?year='.$year);

        $response->assertOk();
        $response->assertDownload("crm-report-sales-monthly-{$year}.csv");
    }
}
