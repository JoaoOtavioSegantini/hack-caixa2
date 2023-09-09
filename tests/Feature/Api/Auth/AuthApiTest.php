<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;

class AuthApiTest extends TestCase
{
    public function test_autenthication_category()
    {
        $this->getJson('/api/postagens')
            ->assertStatus(401);

        $this->getJson('/api/postagens/fake_id')
            ->assertStatus(401);

        $this->postJson('/api/postagens')
            ->assertStatus(401);

        $this->putJson('/api/postagens/fake_id')
            ->assertStatus(401);

        $this->deleteJson('/api/postagens/fake_id')
            ->assertStatus(401);
    }
}
