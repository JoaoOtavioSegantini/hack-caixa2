<?php

namespace Core\UseCase\DTO\Postagem\CriarPostagem;

class CriarPostagemOutputDto
{
    public function __construct(
        public string $id = '',
        public string $titulo = '',
        public string $texto = '',
        public string $slug = '',
        public string $created_at = '',
    ) {
    }
}
