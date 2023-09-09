<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Postagem;
use App\Models\Postagem as Model;
use App\Repositories\Eloquent\PostagemEloquentRepositorio;
use Core\Domain\Entity\Postagem as EntidadePostagem;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\Domain\Repository\PaginacaoInterface;
use Tests\TestCase;
use Throwable;

class PostagemEloquentRepositorioTest extends TestCase
{
    protected $repositorio;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositorio = new PostagemEloquentRepositorio(new Model());
    }

    public function testInsert()
    {
        $entity = new EntidadePostagem(
            titulo: 'Teste',
            texto: "um simples texto"
        );

        $response = $this->repositorio->insert($entity);

        $this->assertInstanceOf(RepositorioPostagemInterface::class, $this->repositorio);
        $this->assertInstanceOf(EntidadePostagem::class, $response);
        $this->assertDatabaseHas('categories', [
            'name' => $entity->name,
        ]);
    }

    public function testFindById()
    {
        $category = Model::factory()->create();
        $response = $this->repositorio->encontrarPorId($category->id);

        $this->assertInstanceOf(EntidadePostagem::class, $response);
        $this->assertEquals($category->id, $response->id());
    }

    public function testFindByIdNotFound()
    {
        try {
            $this->repositorio->findById('fakeValue');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testFindAll()
    {
        $categories = Model::factory()->count(50)->create();

        $response = $this->repositorio->findAll();

        $this->assertEquals(count($categories), count($response));
    }

    public function testPaginate()
    {
        Model::factory()->count(20)->create();

        $response = $this->repositorio->paginate();

        $this->assertInstanceOf(PaginacaoInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function testPaginateWithout()
    {
        $response = $this->repositorio->paginate();

        $this->assertInstanceOf(PaginacaoInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function testUpdateIdNotFound()
    {
        try {
            $category = new EntidadePostagem(titulo: 'test', texto: "um simples texto");
            $this->repositorio->update($category);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testAtualizar()
    {
        $postagemDb = Postagem::factory()->create();

        $category = new EntidadePostagem(
            id: $postagemDb->id,
            titulo: 'updated name',
            texto: "um simples texto"
        );

        $response = $this->repositorio->update($category);

        $this->assertInstanceOf(EntidadePostagem::class, $response);
        $this->assertNotEquals($response->name, $postagemDb->name);
        $this->assertEquals('updated name', $response->name);
    }

    public function testDeletarNaoEncontrado()
    {
        try {
            $this->repositorio->deletar('idfalso');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDeletar()
    {
        $postagemDb = Postagem::factory()->create();

        $resposta = $this->repositorio
            ->delete($postagemDb->id);

        $this->assertTrue($resposta);
    }
}
