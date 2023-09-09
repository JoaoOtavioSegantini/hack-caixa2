<?php

namespace Core\Domain\Entity\Traits;

use Exception;

trait MetodosMagicosTrait
{
    public function __get($atributo)
    {
        if (isset($this->{$atributo})) {
            return $this->{$atributo};
        }

        $nomeClasse = get_class($this);
        throw new Exception("O atributo {$atributo} não foi encontrado na classe {$nomeClasse}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

}
