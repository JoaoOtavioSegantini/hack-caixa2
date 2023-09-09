<?php

namespace App\Repositories\Eloquent;

use App\Models\Postagem as Model;
use App\Repositories\Presenters\PaginacaoPresenter;
use Core\Domain\Entity\Postagem;
use Core\Domain\Exception\NaoEncontradoExcecao;
use Core\Domain\Repository\PaginacaoInterface;
use Core\Domain\Repository\RepositorioPostagemInterface;

class PostagemEloquentRepositorio implements RepositorioPostagemInterface
{
    protected $model;

    public function __construct(Model $postagem)
    {
        $this->model = $postagem;
    }

    public function inserir(Postagem $postagem): Postagem
    {
        $postagem = $this->model->create([
            'id' => $postagem->id(),
            'titulo' => $postagem->titulo,
            'texto' => $postagem->texto,
            'slug' => $postagem->slug,
            'created_at' => $postagem->createdAt(),
        ]);

        return $this->paraPostagem($postagem);
    }

    public function encontrarPorId(string $postagemId): Postagem
    {
        if (!$postagem = $this->model->find($postagemId)) {
            throw new NaoEncontradoExcecao('Post não encontrado');
        }

        return $this->paraPostagem($postagem);
    }

    public function listaDeIds(array $postagemIds = []): array
    {
        return $this->model
            ->whereIn('id', $postagemIds)
            ->pluck('id')
            ->toArray();
    }

    public function encontrarTodos(string $filtro = '', $ordenar = 'DESC'): array
    {
        $postagens = $this->model
            ->where(function ($query) use ($filtro) {
                if ($filtro) {
                    $query->where('name', 'LIKE', "%{$filtro}%");
                }
            })
            ->orderBy('id', $ordenar)
            ->get();

        return $postagens->toArray();
    }

    public function paginar(
        string $filtro = '',
        $ordenar = 'DESC', int $pagina = 1, int $totalPorPagina = 15
    ): PaginacaoInterface {
        $query = $this->model;
        if ($filtro) {
            $query = $query->where('name', 'LIKE', "%{$filtro}%");
        }
        $query = $query->orderBy('id', $ordenar);
        $paginator = $query->paginate();

        return new PaginacaoPresenter($paginator);
    }

    public function atualizar(Postagem $postagem): Postagem
    {
        if (!$postagemDb = $this->model->find($postagem->id())) {
            throw new NaoEncontradoExcecao('Postagem Nao Encontrada');
        }

        $postagemDb->update([
            'titulo' => $postagem->titulo,
            'texto' => $postagem->texto,
            'slug' => $postagem->slug,
        ]);

        $postagemDb->refresh();

        return $this->paraPostagem($postagemDb);
    }

    public function deletar(string $postagemId): bool
    {
        if (!$postagemDb = $this->model->find($postagemId)) {
            throw new NaoEncontradoExcecao('Postagem Nao Encontrada');
        }

        return $postagemDb->delete();
    }

    private function paraPostagem(object $object): Postagem
    {
        return new Postagem(
            id: $object->id,
            titulo: $object->titulo,
            texto: $object->texto,
            slug: $object->slug
        );

    }
}
