<?php

namespace Tests\Feature;

use App\Jobs\ProcessPedigreePdf;
use App\Models\Rabbit;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class RabbitControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Tenant $tenant;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tenant = Tenant::factory()->create();
        $this->user = User::factory()->create(['tenant_id' => $this->tenant->id]);
        $this->actingAs($this->user);
    }

    public function test_index_displays_rabbits()
    {
        Rabbit::factory()->count(3)->create(['tenant_id' => $this->tenant->id]);

        $this->get(route('rabbits.index'))
            ->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Rabbits/Index')
                    ->has('rabbits.data', 3)
            );
    }

    public function test_show_displays_rabbit()
    {
        $rabbit = Rabbit::factory()->create(['tenant_id' => $this->tenant->id]);

        $this->get(route('rabbits.show', $rabbit))
            ->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Rabbits/Show')
                    ->where('rabbit.id', $rabbit->id)
            );
    }

    public function test_user_cannot_view_rabbit_of_another_tenant()
    {
        $otherTenant = Tenant::factory()->create();
        $otherRabbit = Rabbit::factory()->create(['tenant_id' => $otherTenant->id]);

        $this->get(route('rabbits.show', $otherRabbit))
            ->assertForbidden();
    }

    public function test_create_page_is_rendered()
    {
        $this->get(route('rabbits.create'))
            ->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Rabbits/Create')
            );
    }

    public function test_store_creates_rabbit()
    {
        $data = [
            'name' => 'New Rabbit',
            'sex' => 'doe',
            'tattoo_id' => 'NR01',
        ];

        $this->post(route('rabbits.store'), $data)
            ->assertRedirect(route('rabbits.index'));

        $this->assertDatabaseHas('rabbits', array_merge($data, ['tenant_id' => $this->tenant->id]));
    }

    public function test_store_fails_with_invalid_data()
    {
        $this->post(route('rabbits.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_download_pedigree_dispatches_job()
    {
        Queue::fake();

        $rabbit = Rabbit::factory()->create(['tenant_id' => $this->tenant->id]);

        $this->post(route('rabbits.pedigree.download', $rabbit))
            ->assertRedirect();

        Queue::assertPushed(ProcessPedigreePdf::class, function ($job) use ($rabbit) {
            return $job->rabbit->id === $rabbit->id && $job->user->id === $this->user->id;
        });
    }

    public function test_unauthenticated_user_cannot_access_rabbits_index()
    {
        auth()->logout();
        $this->get(route('rabbits.index'))->assertRedirect(route('login'));
    }
}
