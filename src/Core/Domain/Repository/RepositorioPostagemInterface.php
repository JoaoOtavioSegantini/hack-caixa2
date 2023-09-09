<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Postagem;

interface RepositorioPostagemInterface
{
    public function inserir(Postagem $postagem): Postagem;

    public function encontrarPorId(string $postagemId): Postagem;

    public function listaDeIds(array $postagemIds = []): array;

    public function encontrarTodos(string $filtro = '', $ordenar = 'DESC'): array;

    public function paginar(
        string $filtro = '',
        $ordenar = 'DESC',
        int $pagina = 1, int $totalPorPagina = 15
    ): PaginacaoInterface;

    public function atualizar(Postagem $postagem): Postagem;

    public function deletar(string $postagemId): bool;
}
