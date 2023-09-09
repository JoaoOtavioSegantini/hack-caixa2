<?php

namespace Core\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        protected string $value
    ) {
        $this->garantirValidade($value);
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function garantirValidade(string $id)
    {
        if (! RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> não permite o valor <%s>.', static::class, $id));
        }
    }
}
