<?php

namespace Core\Domain\Validation;

use Core\Domain\Entity\Entidade;

interface InterfaceValidator
{
    public function validar(Entidade $entidade): void;
}
