<?php

namespace Tests\Unit;

use App\Http\Controllers\KendaraanController;
use App\Services\KendaraanService;
use Illuminate\Http\Request;
use Tests\TestCase;

class KendaraanControllerTest extends TestCase
{
    public function testGetStokDanKendaraanByPage()
    {
        // Arrange
        $mockRequest = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockRequest->expects($this->any())
            ->method('query')
            ->withConsecutive(
                ['page'],
                ['size']
            )
            ->willReturnOnConsecutiveCalls(1, 10);

        $mockKendaraanService = $this->getMockBuilder(KendaraanService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockKendaraanService->expects($this->once())
            ->method('getStokDanKendaraanByPage')
            ->with(1, 10)
            ->willReturn(['result' => 'dummy_result']);

        $controller = new KendaraanController($mockKendaraanService);

        // Act
        $response = $controller->getStokDanKendaraanByPage($mockRequest);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('dummy_result', $response->getData()->result);
    }
}
