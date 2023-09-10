<?php

namespace Tests\Unit\UseCase\Postagem;

use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\DeletarPostagem\DeletarPostagemOutputDto;
use Core\UseCase\DTO\Postagem\PostagemInputDto;
use Core\UseCase\DTO\Postagem\PostagemOutputDto;
use Core\UseCase\Postagem\DeletarPostagemCasoDeUso;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeletePostagemCasoDeUsoUnitTest extends TestCase
{
    public function testDeletar()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $this->mockRepo = Mockery::mock(stdClass::class, RepositorioPostagemInterface::class);
        $this->mockRepo->shouldReceive('deletar')->andReturn(true);

        $this->mockInputDto = Mockery::mock(PostagemInputDto::class, [$uuid]);

        $useCase = new DeletarPostagemCasoDeUso($this->mockRepo);
        $responseUseCase = $useCase->executar($this->mockInputDto);

        $this->assertInstanceOf(DeletarPostagemOutputDto::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositorioPostagemInterface::class);
        $this->spy->shouldReceive('deletar')->andReturn(true);
        $useCase = new DeletarPostagemCasoDeUso($this->spy);
        $responseUseCase = $useCase->executar($this->mockInputDto);
        $this->spy->shouldHaveReceived('deletar');
    }

    public function testDeletarFalse()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $this->mockRepo = Mockery::mock(stdClass::class, RepositorioPostagemInterface::class);
        $this->mockRepo->shouldReceive('deletar')->andReturn(false);

        $this->mockInputDto = Mockery::mock(PostagemInputDto::class, [$uuid]);

        $useCase = new DeletarPostagemCasoDeUso($this->mockRepo);
        $responseUseCase = $useCase->executar($this->mockInputDto);

        $this->assertInstanceOf(PostagemOutputDto::class, $responseUseCase);
        $this->assertFalse($responseUseCase->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
