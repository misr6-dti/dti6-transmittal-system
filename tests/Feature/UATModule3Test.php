<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transmittal;
use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UATModule3Test extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Run the actual seeder to verify our remediation
        (new \Database\Seeders\RolesAndPermissionsSeeder())->run();
    }

    public function test_3_1_create_transmittal_draft()
    {
        $office = Office::factory()->create();
        $receiverOffice = Office::factory()->create();
        $user = User::factory()->create(['office_id' => $office->id]);
        
        // Assign the remediation role
        $user->assignRole('Office Staff');

        $this->actingAs($user);

        $postData = [
            'reference_number' => 'T-TEST-NEW-001',
            'receiver_office_id' => $receiverOffice->id,
            'transmittal_date' => now()->format('Y-m-d'),
            'remarks' => 'Test Draft Creation',
            'status' => 'Draft',
        ];

        $response = $this->post(route('transmittals.store'), $postData);

        // Debug assertions if fails
        if ($response->status() !== 302 && $response->status() !== 200) {
             dump($response->json());
        }

        // Redirects to show page usually
        $response->assertStatus(302); 

        $this->assertDatabaseHas('transmittals', [
            'sender_user_id' => $user->id,
            'receiver_office_id' => $receiverOffice->id,
            'remarks' => 'Test Draft Creation',
            'status' => 'Draft'
        ]);
    }

    public function test_3_2_edit_draft()
    {
        $office = Office::factory()->create();
        $user = User::factory()->create(['office_id' => $office->id]);
        
        $user->assignRole('Office Staff');
        
        $this->actingAs($user);

        $transmittal = Transmittal::factory()->create([
            'sender_user_id' => $user->id,
            'sender_office_id' => $office->id,
            'status' => 'Draft'
        ]);

        $response = $this->put(route('transmittals.update', $transmittal), [
            'reference_number' => $transmittal->reference_number, // Required
            'receiver_office_id' => $transmittal->receiver_office_id,
            'transmittal_date' => $transmittal->transmittal_date->format('Y-m-d'),
            'remarks' => 'Updated Remarks',
            'status' => 'Draft'
        ]);

        $response->assertSessionHasNoErrors();
        
        $this->assertDatabaseHas('transmittals', [
            'id' => $transmittal->id,
            'remarks' => 'Updated Remarks',
            'status' => 'Draft'
        ]);
    }

    public function test_3_3_submit_transmittal()
    {
        $office = Office::factory()->create();
        $user = User::factory()->create(['office_id' => $office->id]);
        
        $user->assignRole('Office Staff');
        
        $this->actingAs($user);

        $transmittal = Transmittal::factory()->create([
            'sender_user_id' => $user->id,
            'sender_office_id' => $office->id,
            'status' => 'Draft'
        ]);

        $response = $this->put(route('transmittals.update', $transmittal), [
            'reference_number' => $transmittal->reference_number,
            'receiver_office_id' => $transmittal->receiver_office_id,
            'transmittal_date' => $transmittal->transmittal_date->format('Y-m-d'),
            'remarks' => $transmittal->remarks,
            'status' => 'Submitted',
            // Items required when submitting
            'items' => [
                [
                    'quantity' => 1,
                    'description' => 'Test Item'
                ]
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transmittals', [
            'id' => $transmittal->id,
            'status' => 'Submitted'
        ]);
    }

    public function test_3_5_delete_draft()
    {
        $office = Office::factory()->create();
        $user = User::factory()->create(['office_id' => $office->id]);
        
        $user->assignRole('Office Staff');
        
        $this->actingAs($user);

        $transmittal = Transmittal::factory()->create([
            'sender_user_id' => $user->id,
            'sender_office_id' => $office->id,
            'status' => 'Draft'
        ]);

        $response = $this->delete(route('transmittals.destroy', $transmittal));

        $response->assertSessionHasNoErrors();
        
        $this->assertDatabaseMissing('transmittals', [
            'id' => $transmittal->id
        ]);
    }
}
