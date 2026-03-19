<?php

namespace Database\Seeders;

use App\Models\Rabbit;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a primary tenant
        $mainTenant = Tenant::factory()->create([
            'name' => 'Main Rabbitry',
        ]);

        // 2. Create a primary user for that tenant
        $mainUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $mainTenant->id,
        ]);

        // 3. Create a set of rabbits for the main tenant with relationships
        $gGrandSire = Rabbit::factory()->create(['tenant_id' => $mainTenant->id, 'sex' => 'buck', 'name' => 'G-Grand Sire']);
        $gGrandDam = Rabbit::factory()->create(['tenant_id' => $mainTenant->id, 'sex' => 'doe', 'name' => 'G-Grand Dam']);

        $grandSire = Rabbit::factory()->create(['tenant_id' => $mainTenant->id, 'sex' => 'buck', 'sire_id' => $gGrandSire->id, 'dam_id' => $gGrandDam->id, 'name' => 'Grand Sire']);
        $grandDam = Rabbit::factory()->create(['tenant_id' => $mainTenant->id, 'sex' => 'doe', 'name' => 'Grand Dam']);

        $sire = Rabbit::factory()->create(['tenant_id' => $mainTenant->id, 'sex' => 'buck', 'sire_id' => $grandSire->id, 'dam_id' => $grandDam->id, 'name' => 'Father Rabbit']);
        $dam = Rabbit::factory()->create(['tenant_id' => $mainTenant->id, 'sex' => 'doe', 'name' => 'Mother Rabbit']);

        Rabbit::factory()->create([
            'tenant_id' => $mainTenant->id,
            'name' => 'Bunbun',
            'sex' => 'doe',
            'sire_id' => $sire->id,
            'dam_id' => $dam->id
        ]);

        // Create some other unrelated rabbits
        Rabbit::factory()->count(5)->create(['tenant_id' => $mainTenant->id, 'sex' => 'buck']);
        Rabbit::factory()->count(5)->create(['tenant_id' => $mainTenant->id, 'sex' => 'doe']);


        // 4. Create a second tenant with a user and a few rabbits for testing authorization
        $otherTenant = Tenant::factory()->create(['name' => 'Other Rabbitry']);
        User::factory()->create(['tenant_id' => $otherTenant->id, 'email' => 'other@example.com']);
        Rabbit::factory()->count(3)->create(['tenant_id' => $otherTenant->id]);

        $this->command->info('Database seeded!');
        $this->command->info('Main User Login: test@example.com');
        $this->command->info('Password: password');
    }
}
