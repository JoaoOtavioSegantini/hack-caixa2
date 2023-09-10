<?php

namespace Core\UseCase\Postagem;

use Core\Domain\Entity\Postagem;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\CriarPostagem\CriarPostagemInputDto;
use Core\UseCase\DTO\Postagem\CriarPostagem\CriarPostagemOutputDto;

class CriarPostagemCasoDeUso
{
    protected $repositorio;

    public function __construct(RepositorioPostagemInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function executar(CriarPostagemInputDto $input): CriarPostagemOutputDto
    {
        $postagem = new Postagem(
            titulo: $input->titulo,
            texto: $input->texto
        );

        $novaPostagem = $this->repositorio->inserir($postagem);

        return new CriarPostagemOutputDto(
            id: $novaPostagem->id(),
            titulo: $novaPostagem->titulo,
            texto: $novaPostagem->texto,
            slug: Postagem::slugify($novaPostagem->titulo),
            created_at: $postagem->createdAt(),
        );
    }
}
