<?php

namespace Core\UseCase\DTO\Postagem;

class PostagemInputDto
{
    public function __construct(
        public string $id = '',
    ) {
    }
}
