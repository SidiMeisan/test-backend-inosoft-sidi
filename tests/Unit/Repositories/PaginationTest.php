<?php

namespace Tests\Unit\Repositories;

use App\Repositories\Pagination;
use Jenssegers\Mongodb\Query\Builder as MongoBuilder;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testApplyPagination()
    {
        // Arrange
        $page = 2;
        $size = 10;
        $query = $this->getMockBuilder(MongoBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $query->expects($this->once())
            ->method('skip')
            ->with(($page - 1) * $size)
            ->willReturnSelf();
        $query->expects($this->once())
            ->method('take')
            ->with($size)
            ->willReturnSelf();

        $pagination = new Pagination($page, $size);

        // Act
        $result = $pagination->applyPagination($query);

        // Assert
        $this->assertInstanceOf(MongoBuilder::class, $result);
    }

    public function testToArray()
    {
        // Arrange
        $page = 2;
        $size = 10;
        $pagination = new Pagination($page, $size);

        // Act
        $result = $pagination->toArray();

        // Assert
        $expectedResult = [
            'page' => $page,
            'size' => $size,
        ];
        $this->assertEquals($expectedResult, $result);
    }
}