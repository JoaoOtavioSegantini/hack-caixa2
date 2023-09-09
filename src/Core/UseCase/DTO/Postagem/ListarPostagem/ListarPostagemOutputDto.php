<?php

namespace Core\UseCase\DTO\Postagem\ListarPostagem;

class ListarPostagemOutputDto
{
    public function __construct(
        public array $items,
        public int $total,
        public int $pagina_atual,
        public int $ultima_pagina,
        public int $primeira_pagina,
        public int $por_pagina,
        public int $to,
        public int $from,
    ) {
    }
}
