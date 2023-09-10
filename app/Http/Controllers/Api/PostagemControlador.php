<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AtualizarPostagemRequisicao;
use App\Http\Requests\StorePostagemRequest;
use App\Http\Resources\PostagemRecurso;
use Core\Domain\Entity\Postagem;
use Core\UseCase\DTO\Postagem\AtualizarPostagem\AtualizarPostagemInputDto;
use Core\UseCase\DTO\Postagem\CriarPostagem\CriarPostagemInputDto;
use Core\UseCase\DTO\Postagem\ListarPostagem\ListarPostagemInputDto;
use Core\UseCase\DTO\Postagem\PostagemInputDto;
use Core\UseCase\Postagem\AtualizarPostagemCasoDeUso;
use Core\UseCase\Postagem\CriarPostagemCasoDeUso;
use Core\UseCase\Postagem\DeletarPostagemCasoDeUso;
use Core\UseCase\Postagem\ListarPostagemCasoDeUso;
use Core\UseCase\Postagem\ListarPostagensCasoDeUso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostagemControlador extends Controller
{
    public function index(Request $request, ListarPostagensCasoDeUso $useCase)
    {
        $response = $useCase->executar(
            input: new ListarPostagemInputDto(
                filtro: $request->get('filtro', ''),
                ordenar: $request->get('ordenar', 'DESC'),
                pagina: (int) $request->get('pagina', 1),
                totalPagina: (int) $request->get('total_pagina', 15),
            )
        );

        return PostagemRecurso::collection(collect($response->items))
            ->additional([
                'meta' => [
                    'total' => $response->total,
                    'pagina_atual' => $response->pagina_atual,
                    'ultima_pagina' => $response->ultima_pagina,
                    'primeira_pagina' => $response->primeira_pagina,
                    'por_pagina' => $response->por_pagina,
                    'to' => $response->to,
                    'from' => $response->from,
                ],
            ]);
    }

    public function store(StorePostagemRequest $request, CriarPostagemCasoDeUso $useCase)
    {
        $response = $useCase->executar(
            input: new CriarPostagemInputDto(
                titulo: $request->titulo,
                texto: $request->texto,
                slug: Postagem::slugify($request->titulo)
            )
        );

        return (new PostagemRecurso($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListarPostagemCasoDeUso $useCase, $id)
    {
        $postagem = $useCase->executar(new PostagemInputDto($id));

        return (new PostagemRecurso($postagem))->response();
    }

    public function update(AtualizarPostagemRequisicao $request, AtualizarPostagemCasoDeUso $useCase, $id)
    {
        $response = $useCase->executar(
            input: new AtualizarPostagemInputDto(
                id: $id,
                titulo: $request->titulo,
                texto: $request->texto,
                slug: Postagem::slugify($request->titulo)
            )
        );

        return (new PostagemRecurso($response))
            ->response();
    }

    public function destroy(DeletarPostagemCasoDeUso $useCase, $id)
    {
        $useCase->executar(new PostagemInputDto($id));

        return response()->noContent();
    }
}
