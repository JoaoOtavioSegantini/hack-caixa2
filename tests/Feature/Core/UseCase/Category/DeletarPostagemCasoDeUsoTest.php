<?php

namespace Tests\Feature\Core\UseCase\Postagem;

use App\Models\Postagem as Model;
use App\Repositories\Eloquent\PostagemEloquentRepositorio;
use Core\UseCase\Postagem\DeletarPostagemCasoDeUso;
use Core\UseCase\DTO\Postagem\PostagemInputDto;
use Tests\TestCase;

class DeletarPostagemCasoDeUsoTest extends TestCase
{
    public function test_delete()
    {
        $postagemDb = Model::factory()->create();

        $repositorio = new PostagemEloquentRepositorio(new Model());
        $useCase = new DeletarPostagemCasoDeUso($repositorio);
        $useCase->executar(
            new PostagemInputDto(
                id: $postagemDb->id
            )
        );

        $this->assertSoftDeleted($postagemDb);
    }
}
