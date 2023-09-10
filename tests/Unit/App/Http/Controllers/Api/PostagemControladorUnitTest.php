<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Api\PostagemControlador;
use Core\UseCase\Postagem\{
    ListarPostagensCasoDeUso
};
use Core\UseCase\DTO\Postagem\ListarPostagem\ListarPostagemOutputDto;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class PostagemControladorUnitTest extends TestCase
{
    public function testIndex()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')->andReturn('teste');

        $mockDtoOutput = Mockery::mock(ListarPostagemOutputDto::class, [
            [], 1, 1, 1, 1, 1, 1, 1,
        ]);

        $mockUseCase = Mockery::mock(ListarPostagensCasoDeUso::class);
        $mockUseCase->shouldReceive('executar')->andReturn($mockDtoOutput);

        $controller = new PostagemControlador();
        $response = $controller->index($mockRequest, $mockUseCase);

        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta', $response->additional);

        /**
         * Spies
         */
        $mockUseCaseSpy = Mockery::spy(ListarPostagensCasoDeUso::class);
        $mockUseCaseSpy->shouldReceive('executar')->andReturn($mockDtoOutput);
        $controller->index($mockRequest, $mockUseCaseSpy);
        $mockUseCaseSpy->shouldHaveReceived('executar');

        Mockery::close();
    }
}
