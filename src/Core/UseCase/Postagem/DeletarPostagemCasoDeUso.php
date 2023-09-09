<?php

namespace Core\UseCase\Postagem;

use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\DeletarPostagem\DeletarPostagemOutputDto;
use Core\UseCase\DTO\Postagem\PostagemInputDto;

class DeletarPostagemCasoDeUso
{
    protected $repositorio;

    public function __construct(RepositorioPostagemInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function executar(PostagemInputDto $input): DeletarPostagemOutputDto
    {
        $resposta = $this->repositorio->deletar($input->id);

        return new DeletarPostagemOutputDto(
            success: $resposta
        );
    }
}
