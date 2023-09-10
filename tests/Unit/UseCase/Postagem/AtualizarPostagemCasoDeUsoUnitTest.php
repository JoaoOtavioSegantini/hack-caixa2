<?php

namespace Tests\Unit\UseCase\Postagem;

use Core\Domain\Entity\Postagem as PostagemEntity;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\AtualizarPostagem\AtualizarPostagemInputDto;
use Core\UseCase\DTO\Postagem\AtualizarPostagem\AtualizarPostagemOutputDto;
use Core\UseCase\Postagem\AtualizarPostagemCasoDeUso;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class AtualizarPostagemCasoDeUsoUnitTest extends TestCase
{
    public function testRenomearPostagem()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $titulo = 'Novo nome';
        $texto = 'novo post novo post novo post';

        $this->mockEntity = Mockery::mock(PostagemEntity::class, [
            $uuid, $titulo, $texto
        ]);

        $this->mockEntity->shouldReceive('atualizar');
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, RepositorioPostagemInterface::class);
        $this->mockRepo->shouldReceive('encontrarPorId')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('atualizar')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(AtualizarPostagemInputDto::class, [
            $uuid,
            'new title',
            'new text body new text body',
            PostagemEntity::slugify('new title')
        ]);

        $useCase = new AtualizarPostagemCasoDeUso($this->mockRepo);
        $responseUseCase = $useCase->executar($this->mockInputDto);

        $this->assertInstanceOf(AtualizarPostagemOutputDto::class, $responseUseCase);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositorioPostagemInterface::class);
        $this->spy->shouldReceive('encontrarPorId')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('atualizar')->andReturn($this->mockEntity);
        $useCase = new AtualizarPostagemCasoDeUso($this->spy);
        $useCase->executar($this->mockInputDto);
        $this->spy->shouldHaveReceived('encontrarPorId');
        $this->spy->shouldHaveReceived('atualizar');

        Mockery::close();
    }
}
