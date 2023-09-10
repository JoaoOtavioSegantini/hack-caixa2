<?php

namespace Core\Domain\Validation;
use Core\Domain\Exception\EntidadeValidacaoExcecao;


class DominioValidacao
{
    public static function naoNulo(string $valor, string $excecao = null)
    {
        if (empty($valor)) {
            throw new EntidadeValidacaoExcecao($excecao ?? "Não pode ser vazio ou nullo");
        }
    }

    public static function tamanhoMaximo(string $valor, int $tamanho = 255, string $excecao = null)
    {
        if (strlen($valor) >= $tamanho) {
            throw new EntidadeValidacaoExcecao(
                $excecao ?? "O valor não pode ser maior do que o tamanho de {$tamanho} caracteres"
            );
        }
    }

    public static function tamanhoMinimo(string $valor, int $tamanho = 255, string $excecao = null)
    {
        if (strlen($valor) < $tamanho) {
            throw new EntidadeValidacaoExcecao(
                $excecao ?? "O valor deve ter ao menos o tamanho de {$tamanho} caracteres"
            );
        }
    }

    public static function nuloeTamanhoMaximo(string $valor = '', int $tamanho = 255, string $excecao = null)
    {
        if (! empty($valor) && strlen($valor) > $tamanho) {
            throw new EntidadeValidacaoExcecao(
                $excecao ?? "O valor não pode ser maior do que {$tamanho} caracteres"
            );
        }
    }
}
