<?php

namespace Tests\Unit\UseCase\Postagem;

use Core\Domain\Entity\Postagem;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\CriarPostagem\CriarPostagemInputDto;
use Core\UseCase\DTO\Postagem\CriarPostagem\CriarPostagemOutputDto;
use Core\UseCase\Postagem\CriarPostagemCasoDeUso;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CriarPostagemCasoDeUsoUnitTest extends TestCase
{
    public function testCriarNovaPostagem()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $nomePostagem = 'nome post novo post novo post';
        $nomeTitulo = "novo titulo";

        $this->mockEntity = Mockery::mock(Postagem::class, [
            $uuid,
            $nomeTitulo,
            $nomePostagem
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockRepo = Mockery::mock(stdClass::class, RepositorioPostagemInterface::class);
        $this->mockRepo->shouldReceive('inserir')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CriarPostagemInputDto::class, [
            $nomeTitulo,
            $nomePostagem
        ]);

        $useCase = new CriarPostagemCasoDeUso($this->mockRepo);
        $responseUseCase = $useCase->executar($this->mockInputDto);

        $this->assertInstanceOf(CriarPostagemOutputDto::class, $responseUseCase);
        $this->assertEquals($nomePostagem, $responseUseCase->texto);
        $this->assertEquals($nomeTitulo, $responseUseCase->titulo);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositorioPostagemInterface::class);
        $this->spy->shouldReceive('inserir')->andReturn($this->mockEntity);
        $useCase = new CriarPostagemCasoDeUso($this->spy);
        $responseUseCase = $useCase->executar($this->mockInputDto);
        $this->spy->shouldHaveReceived('inserir');

        Mockery::close();
    }
}
