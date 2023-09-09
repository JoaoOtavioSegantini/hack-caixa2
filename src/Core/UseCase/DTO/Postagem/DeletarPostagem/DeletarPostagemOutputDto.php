<?php

namespace Core\UseCase\DTO\Postagem\DeletarPostagem;

class DeletarPostagemOutputDto
{
    public function __construct(
        public bool $success
    ) {
    }
}
