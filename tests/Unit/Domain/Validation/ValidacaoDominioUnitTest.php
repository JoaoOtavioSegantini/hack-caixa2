<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntidadeValidacaoExcecao;
use Core\Domain\Validation\DominioValidacao;
use PHPUnit\Framework\TestCase;
use Throwable;

class ValidacaoDominioUnitTest extends TestCase
{
    public function testNaoNulo()
    {
        try {
            $value = '';
            DominioValidacao::naoNulo($value);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntidadeValidacaoExcecao::class, $th);
        }
    }

    public function testNaoNuloMensagemException()
    {
        try {
            $value = '';
            DominioValidacao::naoNulo($value, 'mensagem de erro customizada');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntidadeValidacaoExcecao::class, $th, 'mensagem de erro customizada');
        }
    }

    public function testTamanhoMaximo()
    {
        try {
            $value = 'Teste';
            DominioValidacao::tamanhoMaximo($value, 3, 'Custom Messagem');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntidadeValidacaoExcecao::class, $th, 'Custom Messagem');
        }
    }

    public function testTamanhoMinimo()
    {
        try {
            $value = 'Test';
            DominioValidacao::tamanhoMinimo($value, 8, 'Custom Messagem');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntidadeValidacaoExcecao::class, $th, 'Custom Messagem');
        }
    }

    public function testStrNuloTamanhoMaximo()
    {
        try {
            $value = 'teste';
            DominioValidacao::nuloeTamanhoMaximo($value, 3, 'Custom Messagem');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntidadeValidacaoExcecao::class, $th, 'Custom Messagem');
        }
    }
}
