<?php

namespace Core\UseCase\Postagem;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\ListarPostagem\ListarPostagemInputDto;
use Core\UseCase\DTO\Postagem\ListarPostagem\ListarPostagemOutputDto;

class ListarPostagensCasoDeUso
{
    protected $repositorio;

    public function __construct(RepositorioPostagemInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function executar(ListarPostagemInputDto $input): ListarPostagemOutputDto
    {
        $postagens = $this->repositorio->paginar(
            filtro: $input->filtro,
            ordenar: $input->ordenar,
            pagina: $input->pagina,
            totalPorPagina: $input->totalPagina,
        );

        return new ListarPostagemOutputDto(
            items: $postagens->items(),
            total: $postagens->total(),
            pagina_atual: $postagens->paginaAtual(),
            ultima_pagina: $postagens->ultimaPagina(),
            primeira_pagina: $postagens->primeiraPagina(),
            por_pagina: $postagens->porPagina(),
            to: $postagens->to(),
            from: $postagens->from(),
        );

    }
}
