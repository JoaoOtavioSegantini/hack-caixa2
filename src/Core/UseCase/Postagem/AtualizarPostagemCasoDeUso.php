<?php

namespace Core\UseCase\Postagem;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\AtualizarPostagem\AtualizarPostagemInputDto;
use Core\UseCase\DTO\Postagem\AtualizarPostagem\AtualizarPostagemOutputDto;

class AtualizarPostagemCasoDeUso
{
    protected $repositorio;

    public function __construct(RepositorioPostagemInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function executar(AtualizarPostagemInputDto $input): AtualizarPostagemOutputDto
    {
        $postagem = $this->repositorio->encontrarPorId($input->id);

        $postagem->atualizar(
            titulo: $input->titulo,
            texto: $input->texto,
        );


        $postagemAtualizada = $this->repositorio->atualizar($postagem);

        return new AtualizarPostagemOutputDto(
            id: $postagemAtualizada->id,
            titulo: $postagemAtualizada->titulo,
            texto: $postagemAtualizada->texto,
            slug: $postagemAtualizada->slug,
            created_at: $postagemAtualizada->createdAt(),
        );
    }
}
