<?php

namespace Tests\Feature\Web;

use App\Models\Lead;
use App\Models\LeadStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_access_user_management_page(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($superadmin)->get('/users');

        $response->assertOk();
        $response->assertSee('Manajemen User');
    }

    public function test_non_superadmin_cannot_access_user_management_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/users');

        $response->assertForbidden();
    }

    public function test_superadmin_can_create_user(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($superadmin)->post('/users', [
            'name' => 'User Baru',
            'email' => 'baru@example.test',
            'role' => 'sales',
            'password' => 'passwordBaru123',
            'password_confirmation' => 'passwordBaru123',
        ]);

        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'email' => 'baru@example.test',
            'role' => 'sales',
        ]);
    }

    public function test_superadmin_can_delete_user_with_related_data_and_reassign_dependencies(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $targetUser = User::factory()->create([
            'role' => 'sales',
        ]);

        $lead = Lead::create([
            'nama_client' => 'Relasi User',
            'perusahaan' => 'PT Relasi',
            'no_hp' => '0812555000',
            'email' => 'relasi@example.test',
            'alamat' => 'Jakarta',
            'sumber_lead' => 'website',
            'status' => 'Warm',
            'assigned_to' => $targetUser->id,
            'notes' => null,
        ]);

        LeadStatusHistory::create([
            'lead_id' => $lead->id,
            'from_status' => 'Cold',
            'to_status' => 'Warm',
            'changed_by' => $targetUser->id,
            'changed_at' => now(),
            'note' => 'Update status',
        ]);

        $response = $this->actingAs($superadmin)->delete("/users/{$targetUser->id}");

        $response->assertRedirect('/users');

        $this->assertDatabaseMissing('users', [
            'id' => $targetUser->id,
        ]);

        $this->assertDatabaseHas('leads', [
            'id' => $lead->id,
            'assigned_to' => $superadmin->id,
        ]);

        $this->assertDatabaseHas('lead_status_histories', [
            'lead_id' => $lead->id,
            'changed_by' => $superadmin->id,
        ]);
    }
}
