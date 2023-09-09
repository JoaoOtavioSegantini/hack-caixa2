<?php

namespace Core\UseCase\DTO\Postagem\AtualizarPostagem;

class AtualizarPostagemInputDto
{
    public function __construct(
        public string $id,
        public string $titulo,
        public string $texto,
        public string $slug,
    ) {
    }
}
