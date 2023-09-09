<?php

namespace Core\UseCase\DTO\Postagem\ListarPostagem;

class ListarPostagemInputDto
{
    public function __construct(
        public string $filtro = '',
        public string $ordenar = 'DESC',
        public int $pagina = 1,
        public int $totalPagina = 15,
    ) {
    }
}
