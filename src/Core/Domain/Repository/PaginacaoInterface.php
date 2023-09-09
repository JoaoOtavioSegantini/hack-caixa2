<?php

namespace Core\Domain\Repository;

interface PaginacaoInterface
{
    /**
     * @return \stdClass[]
     */
    public function items(): array;

    public function total(): int;

    public function ultimaPagina(): int;

    public function primeiraPagina(): int;

    public function paginaAtual(): int;

    public function porPagina(): int;

    public function to(): int;

    public function from(): int;
}
