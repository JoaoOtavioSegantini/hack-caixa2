<?php

namespace Tests\Feature\Api;

use App\Models\Postagem;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class PostagemApiTest extends TestCase
{
    use WithoutMiddlewareTrait;

    protected $endpoint = '/api/postagens';

    public function test_list_empty_postagens()
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_listar_todas_as_postagens()
    {
        Postagem::factory()->count(30)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'pagina_atual',
                'ultima_pagina',
                'primeira_pagina',
                'por_pagina',
                'to',
                'from',
            ],
        ]);
        $response->assertJsonCount(15, 'data');
    }

    public function test_listar_todas_as_postagens_paginadas()
    {
        Postagem::factory()->count(25)->create();

        $response = $this->getJson("$this->endpoint?page=2");

        $response->assertStatus(200);
        $this->assertEquals(2, $response['meta']['pagina_atual']);
        $this->assertEquals(25, $response['meta']['total']);
        $response->assertJsonCount(10, 'data');
    }

    public function test_testar_excecao_quando_nao_encontrar_postagens()
    {
        $response = $this->getJson("$this->endpoint/fake_value");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_listar_postagem()
    {
        $postagem = Postagem::factory()->create();

        $response = $this->getJson("$this->endpoint/{$postagem->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'titulo',
                'texto',
                'slug',
                'created_at',
            ],
        ]);
        $this->assertEquals($postagem->id, $response['data']['id']);
    }

    public function test_validacoes_na_criacao()
    {
        $data = [];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'titulo',
                'texto'
            ],
        ]);
    }

    public function test_metodo_store()
    {
        $data = [
            'titulo' => 'Novo Titulo',
            'texto' => 'novo texto aleatorio'
        ];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'titulo',
                'texto',
                'slug',
                'created_at',
            ],
        ]);

        $response = $this->postJson($this->endpoint, [
            'titulo' => 'titulo aleatorio',
            'texto' => 'lorem ipsum lorem ipsum'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('titulo aleatorio', $response['data']['titulo']);
        $this->assertEquals('lorem ipsum lorem ipsum', $response['data']['texto']);
        $this->assertEquals('titulo-aleatorio', $response['data']['slug']);
        $this->assertDatabaseHas('postagens', [
            'id' => $response['data']['id'],
            'titulo' => $response['data']['titulo'],
        ]);
    }

    public function test_nao_encontrado_na_atualizacao()
    {
        $data = [
            'titulo' => 'Novo titulo aleatorio',
            'texto' => 'novo novo',
            'slug' => 'slug'
        ];

        $response = $this->putJson("{$this->endpoint}/fake_id", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_validacoes_no_update()
    {
        $postagem = Postagem::factory()->create();

        $response = $this->putJson("{$this->endpoint}/{$postagem->id}", []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'titulo',
            ],
        ]);
    }

    public function test_atualizacao()
    {
        $postagem = Postagem::factory()->create();

        $data = [
            'titulo' => 'Titulo atualizado',
            'texto' => 'novo texto',
            'slug' => 'slug'
        ];

        $response = $this->putJson("{$this->endpoint}/{$postagem->id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'titulo',
                'texto',
                'slug',
                'created_at',
            ],
        ]);
        $this->assertDatabaseHas('postagens', [
            'titulo' => 'Titulo atualizado',
        ]);
    }

    public function test_nao_encontrado_excecao_na_delecao()
    {
        $response = $this->deleteJson("{$this->endpoint}/fake_id");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delecao()
    {
        $postagem = Postagem::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$postagem->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted('postagens', [
            'id' => $postagem->id,
        ]);
    }
}
