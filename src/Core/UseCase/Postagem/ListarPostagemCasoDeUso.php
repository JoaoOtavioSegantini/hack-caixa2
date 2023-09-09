<?php

namespace Core\UseCase\Postagem;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\PostagemInputDto;
use Core\UseCase\DTO\Postagem\PostagemOutputDto;

class ListarPostagemCasoDeUso
{
    protected $repositorio;

    public function __construct(RepositorioPostagemInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function executar(PostagemInputDto $input): PostagemOutputDto
    {
        $postagem = $this->repositorio->encontrarPorId($input->id);

        return new PostagemOutputDto(
            id: $postagem->id(),
            titulo: $postagem->titulo,
            texto: $postagem->texto,
            slug: $postagem->slug,
            created_at: $postagem->createdAt(),
        );
    }
}
