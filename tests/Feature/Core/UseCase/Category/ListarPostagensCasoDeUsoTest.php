<?php

namespace Tests\Feature\Core\UseCase\Postagem;

use App\Models\Postagem as Model;
use App\Repositories\Eloquent\PostagemEloquentRepositorio;
use Core\UseCase\Postagem\ListarPostagensCasoDeUso;
use Core\UseCase\DTO\Postagem\ListarPostagem\ListarPostagemInputDto;
use Tests\TestCase;

class ListarPostagensCasoDeUsoTest extends TestCase
{
    public function test_list_empty()
    {
        $responseUseCase = $this->createUseCase();

        $this->assertCount(0, $responseUseCase->items);
    }

    public function test_list_all()
    {
        $categoriesDb = Model::factory()->count(20)->create();

        $responseUseCase = $this->createUseCase();

        $this->assertCount(15, $responseUseCase->items);
        $this->assertEquals(count($categoriesDb), $responseUseCase->total);
    }

    private function createUseCase()
    {
        $repository = new PostagemEloquentRepositorio(new Model());
        $useCase = new ListarPostagensCasoDeUso($repository);

        return $useCase->executar(new ListarPostagemInputDto());
    }
}
