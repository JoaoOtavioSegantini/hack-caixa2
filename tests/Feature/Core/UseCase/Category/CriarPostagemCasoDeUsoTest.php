<?php

namespace Tests\Feature\Core\UseCase\Postagem;

use App\Models\Postagem as Model;
use App\Repositories\Eloquent\PostagemEloquentRepositorio;
use Core\UseCase\Postagem\CriarPostagemCasoDeUso;
use Core\UseCase\DTO\Postagem\CriarPostagem\CriarPostagemInputDto;
use Tests\TestCase;

class CriarPostagemCasoDeUsoTest extends TestCase
{
    public function test_create()
    {
        $repository = new PostagemEloquentRepositorio(new Model());
        $useCase = new CriarPostagemCasoDeUso($repository);
        $responseUseCase = $useCase->executar(
            new CriarPostagemInputDto(
                titulo: 'Teste',
                texto: 'texto de teste'
            )
        );

        $this->assertEquals('Teste', $responseUseCase->titulo);
        $this->assertEquals('texto de teste', $responseUseCase->texto);
        $this->assertNotEmpty($responseUseCase->id);

        $this->assertDatabaseHas('postagens', [
            'id' => $responseUseCase->id,
        ]);
    }
}
