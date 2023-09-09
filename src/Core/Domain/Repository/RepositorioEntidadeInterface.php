<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Entidade;

interface RepositorioEntidadeInterface
{
    public function inserir(Entidade $entidade): Entidade;

    public function encontrarPorId(string $entidadeId): Entidade;

    public function encontrarTodos(string $filtro = '', $ordenar = 'DESC'): array;

    public function paginar(
        string $filtro = '',
        $ordenar = 'DESC', int $pagina = 1,
        int $totalPorPagina = 15
    ): PaginacaoInterface;

    public function atualizar(Entidade $entidade): Entidade;

    public function deletar(string $entidadeId): bool;
}
