<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SecretTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_secret_is_deleted_after_read()
    {
        $create = $this->postJson('/api/v1/secrets', [
            'text' => 'top-secret'
        ]);

        $create->assertCreated();

        $id = $create->json('data.id');

        $this->getJson("/api/v1/secrets/$id")
            ->assertOk();

        $this->getJson("/api/v1/secrets/$id")
            ->assertNotFound();
    }

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
