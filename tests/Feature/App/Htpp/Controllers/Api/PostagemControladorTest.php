<?php

namespace Tests\Feature\App\Htpp\Controllers\Api;

use App\Http\Controllers\Api\PostagemControlador;
use App\Http\Requests\StorePostagemRequest;
use App\Http\Requests\AtualizacaoPostagemRequest;
use App\Models\Postagem;
use App\Repositories\Eloquent\PostagemEloquentRepositorio;
use Core\UseCase\Postagem\CriarPostagemCasoDeUso;
use Core\UseCase\Postagem\DeletarPostagemCasoDeUso;
use Core\UseCase\Postagem\ListarPostagensCasoDeUso;
use Core\UseCase\Postagem\ListarPostagemCasoDeUso;
use Core\UseCase\Postagem\AtualizarPostagemCasoDeUso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class PostagemControladorTest extends TestCase
{
    protected $repositorio;

    protected $controlador;

    protected function setUp(): void
    {
        $this->repositorio = new PostagemEloquentRepositorio(
            new Postagem()
        );
        $this->controlador = new PostagemControlador();

        parent::setUp();
    }

    public function test_index()
    {
        $useCase = new ListarPostagensCasoDeUso($this->repositorio);

        $response = $this->controlador->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);
    }

    public function test_store()
    {
        $useCase = new CriarPostagemCasoDeUso($this->repositorio);

        $request = new StorePostagemRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Teste',
        ]));

        $response = $this->controlador->store($request, $useCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }

    public function test_show()
    {
        $category = Postagem::factory()->create();

        $response = $this->controlador->show(
            useCase: new ListarPostagemCasoDeUso($this->repositorio),
            id: $category->id,
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    public function test_update()
    {
        $category = Postagem::factory()->create();

        $request = new AtualizacaoPostagemRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Updated',
        ]));

        $response = $this->controlador->update(
            request: $request,
            useCase: new AtualizarPostagemCasoDeUso($this->repositorio),
            id: $category->id
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertDatabaseHas('categories', [
            'name' => 'Updated',
        ]);
    }

    public function test_delete()
    {
        $category = Postagem::factory()->create();

        $response = $this->controlador->destroy(
            useCase: new DeletarPostagemCasoDeUso($this->repositorio),
            id: $category->id
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
    }
}
