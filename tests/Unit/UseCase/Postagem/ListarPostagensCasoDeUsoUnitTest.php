<?php

namespace Tests\Unit\UseCase\Postagem;

use Core\Domain\Repository\PaginacaoInterface;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Core\UseCase\DTO\Postagem\ListarPostagem\ListarPostagemInputDto;
use Core\UseCase\DTO\Postagem\ListarPostagem\ListarPostagemOutputDto;
use Core\UseCase\Postagem\ListarPostagensCasoDeUso;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListarPostagemUnitTest extends TestCase
{
    public function testListarPostagemVazia()
    {
        $mockPagination = $this->mockPagination();

        $this->mockRepo = Mockery::mock(stdClass::class, RepositorioPostagemInterface::class);
        $this->mockRepo->shouldReceive('paginar')->andReturn($mockPagination);

        $this->mockInputDto = Mockery::mock(ListarPostagemInputDto::class, ['filtro', 'desc']);

        $useCase = new ListarPostagensCasoDeUso($this->mockRepo);
        $responseUseCase = $useCase->executar($this->mockInputDto);

        $this->assertCount(0, $responseUseCase->items);
        $this->assertInstanceOf(ListarPostagemOutputDto::class, $responseUseCase);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, RepositorioPostagemInterface::class);
        $this->spy->shouldReceive('paginar')->andReturn($mockPagination);
        $useCase = new ListarPostagensCasoDeUso($this->spy);
        $useCase->executar($this->mockInputDto);
        $this->spy->shouldHaveReceived('paginar');
    }

    public function testListarPostagens()
    {
        $register = new stdClass();
        $register->id = 'id';
        $register->name = 'name';
        $register->description = 'description';
        $register->is_active = 'is_active';
        $register->created_at = 'created_at';
        $register->updated_at = 'created_at';
        $register->deleted_at = 'created_at';

        $mockPagination = $this->mockPagination([
            $register,
        ]);

        $this->mockRepo = Mockery::mock(stdClass::class, RepositorioPostagemInterface::class);
        $this->mockRepo->shouldReceive('paginar')->andReturn($mockPagination);

        $this->mockInputDto = Mockery::mock(ListarPostagemInputDto::class, ['filtro', 'desc']);

        $useCase = new ListarPostagensCasoDeUso($this->mockRepo);
        $responseUseCase = $useCase->executar($this->mockInputDto);

        $this->assertCount(1, $responseUseCase->items);
        $this->assertInstanceOf(stdClass::class, $responseUseCase->items[0]);
        $this->assertInstanceOf(ListarPostagemOutputDto::class, $responseUseCase);
    }

    protected function mockPagination(array $items = [])
    {
        $this->mockPagination = Mockery::mock(stdClass::class, PaginacaoInterface::class);
        $this->mockPagination->shouldReceive('items')->andReturn($items);
        $this->mockPagination->shouldReceive('total')->andReturn(0);
        $this->mockPagination->shouldReceive('paginaAtual')->andReturn(0);
        $this->mockPagination->shouldReceive('primeiraPagina')->andReturn(0);
        $this->mockPagination->shouldReceive('ultimaPagina')->andReturn(0);
        $this->mockPagination->shouldReceive('porPagina')->andReturn(0);
        $this->mockPagination->shouldReceive('to')->andReturn(0);
        $this->mockPagination->shouldReceive('from')->andReturn(0);

        return $this->mockPagination;
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
