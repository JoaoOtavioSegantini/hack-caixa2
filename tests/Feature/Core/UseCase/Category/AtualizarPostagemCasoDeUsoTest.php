<?php

namespace Tests\Feature\Core\UseCase\Postagem;

use App\Models\Postagem as Model;
use App\Repositories\Eloquent\PostagemEloquentRepositorio;
use Core\UseCase\Postagem\AtualizarPostagemCasoDeUso;
use Core\UseCase\DTO\Postagem\AtualizarPostagem\AtualizarPostagemInputDto;
use Tests\TestCase;

class AtualizarPostagemCasoDeUsoTest extends TestCase
{

    public function test_update()
    {
        $postagemDb = Model::factory()->create();
        $repositorio = new PostagemEloquentRepositorio(new Model());
        $useCase = new AtualizarPostagemCasoDeUso($repositorio);
        $responseUseCase = $useCase->executar(
            new AtualizarPostagemInputDto(
                id: $postagemDb->id,
                titulo: 'name updated',
                texto: $postagemDb->texto,
                slug: $postagemDb->slug
            )
        );

        $this->assertEquals('name updated', $responseUseCase->titulo);
        $this->assertEquals($postagemDb->texto,$responseUseCase->texto);

        $this->assertDatabaseHas('postagens', [
            'titulo' => $responseUseCase->titulo,
        ]);
    }
}
