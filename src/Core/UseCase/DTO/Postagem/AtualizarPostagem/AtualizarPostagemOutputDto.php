<?php

namespace Core\UseCase\DTO\Postagem\AtualizarPostagem;

class AtualizarPostagemOutputDto
{
    public function __construct(
        public string $id,
        public string $titulo = '',
        public string $texto = '',
        public string $slug = '',
        public string $created_at = '',
    ) {
    }
}
