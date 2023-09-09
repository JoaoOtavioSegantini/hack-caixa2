<?php

namespace Core\UseCase\DTO\Postagem;

class PostagemOutputDto
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
