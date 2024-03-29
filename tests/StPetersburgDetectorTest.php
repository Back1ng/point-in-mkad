<?php declare(strict_types=1);

namespace Back1ng\Tests;

use Back1ng\PointInMkad\Polygons\StPetersburgRingRoadPolygon;
use Location\Coordinate;
use PHPUnit\Framework\TestCase;
use Back1ng\PointInMkad\Detector;

final class StPetersburgDetectorTest extends TestCase
{
    /**
     * @dataProvider stPetersburgCoordinateProvider
     */
    public function testCoordinateCorrectDetectInStPetersburg(Coordinate $coordinate): void
    {
        $detector = new Detector(
            coordinates: new StPetersburgRingRoadPolygon(),
        );

        $this->assertTrue($detector->isPointInPolygon($coordinate));
    }

    /**
     * @dataProvider outsideStPetersburgCoordinateProvider
     */
    public function testCoordinateCorrectDetectOutsideStPetersburg(Coordinate $coordinate): void
    {
        $detector = new Detector(
            coordinates: new StPetersburgRingRoadPolygon(),
        );

        $this->assertFalse($detector->isPointInPolygon($coordinate));
    }

    /**
     * @return array<array{Coordinate}>
     */
    public function stPetersburgCoordinateProvider(): array
    {
        return [
            [new Coordinate(60.084398, 30.370613)],
            [new Coordinate(59.907555, 30.460150)],
            [new Coordinate(59.895351, 29.728136)],
            [new Coordinate(59.991789, 29.775845)],
            [new Coordinate(59.866549, 30.525910)],
        ];
    }

    /**
     * @return array<array{Coordinate}>
     */
    public function outsideStPetersburgCoordinateProvider(): array
    {
        return [
            [new Coordinate(59.901957, 30.546255)],
            [new Coordinate(59.865637, 29.745086)],
            [new Coordinate(60.072334, 29.970632)],
            [new Coordinate(60.102903, 30.331472)],
            [new Coordinate(59.989638, 30.648782)],
        ];
    }
}