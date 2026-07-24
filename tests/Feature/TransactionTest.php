<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_add_an_income_transaction_to_a_project(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);

        $this->actingAs($this->user)
            ->post(route('projects.transactions.store', $project), [
                'type'             => 'income',
                'amount'           => 500000,
                'description'      => 'DP 50%',
                'transaction_date' => now()->format('Y-m-d'),
            ])
            ->assertRedirect(route('projects.show', $project))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('transactions', [
            'project_id'  => $project->id,
            'type'        => 'income',
            'amount'      => 500000,
            'description' => 'DP 50%',
        ]);
    }

    /** @test */
    public function user_can_add_an_expense_transaction(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);

        $this->actingAs($this->user)
            ->post(route('projects.transactions.store', $project), [
                'type'             => 'expense',
                'amount'           => 100000,
                'description'      => 'Pembelian domain',
                'transaction_date' => now()->format('Y-m-d'),
            ])
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('transactions', [
            'type'   => 'expense',
            'amount' => 100000,
        ]);
    }

    /** @test */
    public function user_can_upload_payment_proof(): void
    {
        Storage::fake('public');
        $project = Project::factory()->create(['category' => 'personal']);

        $this->actingAs($this->user)
            ->post(route('projects.transactions.store', $project), [
                'type'             => 'income',
                'amount'           => 200000,
                'description'      => 'Pelunasan',
                'transaction_date' => now()->format('Y-m-d'),
                'payment_proof'    => UploadedFile::fake()->image('bukti.jpg'),
            ])
            ->assertRedirect();

        $transaction = Transaction::first();
        $this->assertNotNull($transaction->payment_proof);
        Storage::disk('public')->assertExists($transaction->payment_proof);
    }

    /** @test */
    public function transaction_type_must_be_valid(): void
    {
        $project = Project::factory()->create(['category' => 'personal']);

        $this->actingAs($this->user)
            ->post(route('projects.transactions.store', $project), [
                'type'             => 'invalid_type',
                'amount'           => 100000,
                'transaction_date' => now()->format('Y-m-d'),
            ])
            ->assertSessionHasErrors('type');
    }

    /** @test */
    public function user_can_delete_a_transaction(): void
    {
        $project     = Project::factory()->create(['category' => 'personal']);
        $transaction = Transaction::factory()->create(['project_id' => $project->id]);

        $this->actingAs($this->user)
            ->delete(route('transactions.destroy', $transaction))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
}
