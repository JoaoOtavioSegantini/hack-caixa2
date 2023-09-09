<?php

namespace Tests\Unit\Domain\Notification;

use Core\Domain\Notification\Notificacao;
use PHPUnit\Framework\TestCase;

class NotificacaoUnitTest extends TestCase
{
    public function testColetarErros()
    {
        $notificacao = new Notificacao();
        $erros = $notificacao->pegarErros();

        $this->assertIsArray($erros);
    }

    public function testAdicionarErros()
    {
        $notificacao = new Notificacao();
        $notificacao->adicionarErro([
            'context' => 'video',
            'message' => 'video title is required',
        ]);

        $erros = $notificacao->pegarErros();

        $this->assertCount(1, $erros);
    }

    public function testTemErros()
    {
        $notificacao = new Notificacao();
        $temErros = $notificacao->temErros();
        $this->assertFalse($temErros);

        $notificacao->adicionarErro([
            'context' => 'video',
            'message' => 'video title is required',
        ]);
        $this->assertTrue($notificacao->temErros());
    }

    public function testMessagem()
    {
        $notificacao = new Notificacao();
        $notificacao->adicionarErro([
            'context' => 'video',
            'message' => 'title is required',
        ]);
        $notificacao->adicionarErro([
            'context' => 'video',
            'message' => 'description is required',
        ]);
        $mensagem = $notificacao->mensagens();

        $this->assertIsString($mensagem);
        $this->assertEquals(
            expected: 'video: title is required,video: description is required,',
            actual: $mensagem
        );
    }

    public function testMessageFilterContext()
    {
        $notificacao = new Notificacao();
        $notificacao->adicionarErro([
            'context' => 'video',
            'message' => 'title is required',
        ]);
        $notificacao->adicionarErro([
            'context' => 'category',
            'message' => 'name is required',
        ]);

        $this->assertCount(2, $notificacao->pegarErros());

        $mensagem = $notificacao->mensagens(
            contexto: 'video'
        );
        $this->assertIsString($mensagem);
        $this->assertEquals(
            expected: 'video: title is required,',
            actual: $mensagem
        );
    }
}
