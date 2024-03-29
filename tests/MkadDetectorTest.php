<?php declare(strict_types=1);

namespace Back1ng\Tests;

use Location\Coordinate;
use PHPUnit\Framework\TestCase;
use Back1ng\PointInMkad\Detector;

final class MkadDetectorTest extends TestCase
{
    /**
     * @dataProvider mkadCoordinateProvider
     */
    public function testCoordinateCorrectDetectInMkad(Coordinate $coordinate): void
    {
        $detector = new Detector();

        $this->assertTrue($detector->isPointInPolygon($coordinate));
    }

    /**
     * @dataProvider outsideMkadCoordinateProvider
     */
    public function testCoordinateCorrectDetectOutsideMkad(Coordinate $coordinate): void
    {
        $detector = new Detector();

        $this->assertFalse($detector->isPointInPolygon($coordinate));
    }

    /**
     * @return array<array{Coordinate}>
     */
    public function mkadCoordinateProvider(): array
    {
        return [
            [new Coordinate(55.833747, 37.603032)],
            [new Coordinate(55.879515, 37.438817)],
            [new Coordinate(55.572873, 37.674250)],
            [new Coordinate(55.662948, 37.692710)],
            [new Coordinate(55.661477, 37.558428)],
        ];
    }

    /**
     * @return array<array{Coordinate}>
     */
    public function outsideMkadCoordinateProvider(): array
    {
        return [
            [new Coordinate(55.809518, 37.384814)],
            [new Coordinate(55.890514, 37.830762)],
            [new Coordinate(54.910735, 40.464985)],
            [new Coordinate(45.625829, 46.369457)],
            [new Coordinate(55.585844, 37.716193)],
        ];
    }
}