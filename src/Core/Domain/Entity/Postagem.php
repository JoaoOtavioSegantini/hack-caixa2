<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MetodosMagicosTrait;
use Core\Domain\Validation\DominioValidacao;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Postagem
{
    use MetodosMagicosTrait;

    public function __construct(
        protected Uuid|string $id = '',
        protected string $titulo = '',
        protected string $texto = '',
        protected string $slug = '',
        protected DateTime|string $createdAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
        $this->validar();
    }


    public function atualizar(string $titulo, string $texto)
    {
        $this->titulo = $titulo;
        $this->slug = $this->slugify($titulo);
        $this->texto = $texto;

        $this->validar();
    }

    protected function validar()
    {
        DominioValidacao::naoNulo($this->titulo);
        DominioValidacao::naoNulo($this->texto);
        DominioValidacao::tamanhoMaximo($this->titulo, 30);
        DominioValidacao::tamanhoMinimo($this->titulo, 5);
        DominioValidacao::tamanhoMinimo($this->texto, 5);
    }

    public static function slugify($text, string $divider = '-'): string
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}
