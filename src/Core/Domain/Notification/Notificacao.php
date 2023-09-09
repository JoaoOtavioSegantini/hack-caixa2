<?php

namespace Core\Domain\Notification;

class Notificacao
{
    private $erros = [];

    public function pegarErros()
    {
        return $this->erros;
    }

    /**
     * @param $erro array[context, mensage]
     */
    public function adicionarErro(array $erro): void
    {
        array_push($this->erros, $erro);
    }

    public function temErros(): bool
    {
        return count($this->erros) > 0;
    }

    public function mensagens(string $contexto = ''): string
    {
        $mensagens = '';

        foreach ($this->erros as $erro) {
            if ($contexto === '' || $erro['context'] == $contexto) {
                $mensagens .= "{$erro['context']}: {$erro['message']},";
            }
        }

        return $mensagens;
    }
}
