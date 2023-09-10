<?php

namespace Core\UseCase\DTO\Postagem\CriarPostagem;

class CriarPostagemInputDto
{
    public function __construct(
        public string $titulo = '',
        public string $texto = '',
        public string $slug = '',
    ) {
    }
}
