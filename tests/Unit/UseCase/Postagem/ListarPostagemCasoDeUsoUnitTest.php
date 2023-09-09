<?php

namespace Tests\Unit\UseCase\Postagem;

use Core\Domain\Entity\Postagem as EntidadePostagem;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\PostagemInputDto;
use Core\UseCase\DTO\Postagem\PostagemOutputDto;
use Core\UseCase\Postagem\ListarPostagemCasoDeUso;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListarPostagemCasoDeUsoUnitTest extends TestCase
{
    public function testPegarId()
    {
        $id = (string) Uuid::uuid4()->toString();

        $this->mockEntity = Mockery::mock(EntidadePostagem::class, [
            $id,
            'teste postagem',
            'novo post novo post novo post novo post'
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, RepositorioPostagemInterface::class);
        $this->mockRepo->shouldReceive('encontrarPorId')
            ->with($id)
            ->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(PostagemInputDto::class, [
            $id,
        ]);

        $useCase = new ListarPostagemCasoDeUso($this->mockRepo);
        $response = $useCase->executar($this->mockInputDto);

        $this->assertInstanceOf(PostagemOutputDto::class, $response);
        $this->assertEquals('teste postagem', $response->titulo);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositorioPostagemInterface::class);
        $this->spy->shouldReceive('encontrarPorId')->with($id)->andReturn($this->mockEntity);
        $useCase = new ListarPostagemCasoDeUso($this->spy);
        $response = $useCase->executar($this->mockInputDto);
        $this->spy->shouldHaveReceived('encontrarPorId');
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
