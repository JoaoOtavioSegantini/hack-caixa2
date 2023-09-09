<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Postagem;
use Core\Domain\Exception\EntidadeValidacaoExcecao;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class PostagemUnitTest extends TestCase
{
    protected $titulo = 'Novo titulo';

    protected $texto = 'Novo texto';

    public function testAtributos()
    {
        $postagem = new Postagem(
            titulo: $this->titulo,
            texto: $this->texto
        );

        $this->assertNotEmpty($postagem->createdAt());
        $this->assertNotEmpty($postagem->id());
#        $this->assertNotEmpty($postagem->slug);
        $this->assertEquals($this->titulo, $postagem->titulo);
        $this->assertEquals($this->texto, $postagem->texto);
#        $this->assertEquals(Postagem::slugify($this->titulo), $postagem->slug);
    }


    public function testAtualizacao()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $postagem = new Postagem(
            id: $uuid,
            titulo: $this->titulo,
            texto: $this->texto,
            createdAt: '2023-01-01 12:12:12'
        );

        $postagem->atualizar(
            titulo: 'new_title',
            texto: 'new_text',
        );

        $this->assertEquals($uuid, $postagem->id());
        $this->assertEquals('new_title', $postagem->titulo);
        $this->assertEquals('new_text', $postagem->texto);
    }

    public function testExcecaoTitulo()
    {
        try {
            new Postagem(
                titulo: '',
                texto: $this->texto
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntidadeValidacaoExcecao::class, $th);
        }
    }

    public function testExcecaoTexto()
    {
        try {
            new Postagem(
                titulo: $this->titulo,
                texto: ''
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntidadeValidacaoExcecao::class, $th);
        }
    }
}
