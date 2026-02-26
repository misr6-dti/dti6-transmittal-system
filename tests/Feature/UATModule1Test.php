<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UATModule1Test extends TestCase
{
    use RefreshDatabase;

    public function test_1_1_valid_login()
    {
        $user = User::factory()->create([
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'name' => 'Default Office Staff'
        ]);

        $response = $this->post('/login', [
            'email' => 'staff@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    public function test_1_2_invalid_login()
    {
        $user = User::factory()->create([
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'staff@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    public function test_1_3_profile_update()
    {
        $user = User::factory()->create([
             'name' => 'Old Name',
             'email' => 'old@example.com',
        ]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'old@example.com', // Keep email same to avoid verification logic complications
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('profile.edit'));
        
        $user->refresh();
        $this->assertEquals('New Name', $user->name);
    }

    public function test_1_4_change_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasNoErrors();
        
        // Verify we can login with new password
        $this->post('/logout');
        
        $loginResponse = $this->post('/login', [
            'email' => $user->email,
            'password' => 'new-password',
        ]);
        
        $this->assertAuthenticatedAs($user);
    }

    public function test_1_5_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
