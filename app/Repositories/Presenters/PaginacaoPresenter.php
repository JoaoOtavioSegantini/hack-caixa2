<?php

namespace App\Repositories\Presenters;

use Core\Domain\Repository\PaginacaoInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;

class PaginacaoPresenter implements PaginacaoInterface
{
    /**
     * @return stdClass[]
     */
    protected array $items = [];

    public function __construct(
        protected LengthAwarePaginator $paginator
    ) {
        $this->items = $this->resolveItems(
            items: $this->paginator->items()
        );
    }

    /**
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->paginator->total() ?? 0;
    }

    public function ultimaPagina(): int
    {
        return $this->paginator->lastPage() ?? 0;
    }

    public function primeiraPagina(): int
    {
        return $this->paginator->firstItem() ?? 0;
    }

    public function paginaAtual(): int
    {
        return $this->paginator->currentPage() ?? 0;
    }

    public function porPagina(): int
    {
        return $this->paginator->perPage() ?? 0;
    }

    public function to(): int
    {
        return $this->paginator->firstItem() ?? 0;
    }

    public function from(): int
    {
        return $this->paginator->lastItem() ?? 0;
    }

    private function resolveItems(array $items): array
    {
        $response = [];

        foreach ($items as $item) {
            $stdClass = new stdClass;
            foreach ($item->toArray() as $key => $value) {
                $stdClass->{$key} = $value;
            }

            array_push($response, $stdClass);
        }

        return $response;
    }
}