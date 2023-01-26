<?php

namespace Back1ng\Tests;

use Back1ng\PointInMkad\Polygons\YekaterinburgRingRoadPolygon;
use Location\Coordinate;
use PHPUnit\Framework\TestCase;
use Back1ng\PointInMkad\Detector;

class YekaterinburgDetectorTest extends TestCase
{
    /**
     * @dataProvider yekaterinburgCoordinateProvider
     */
    public function testCoordinateCorrectDetectInYekaterinburg(Coordinate $coordinate): void
    {
        $detector = new Detector(
            coordinates: new YekaterinburgRingRoadPolygon(),
        );

        $this->assertTrue($detector->isPointInPolygon($coordinate));
    }

    /**
     * @dataProvider outsideYekaterinburgCoordinateProvider
     */
    public function testCoordinateCorrectDetectOutsideYekaterinburg(Coordinate $coordinate): void
    {
        $detector = new Detector(
            coordinates: new YekaterinburgRingRoadPolygon(),
        );

        $this->assertFalse($detector->isPointInPolygon($coordinate));
    }

    /**
     * @return array<array{Coordinate}>
     */
    public function yekaterinburgCoordinateProvider(): array
    {
        return [
            [new Coordinate(56.874825, 60.764961)],
            [new Coordinate(56.931860, 60.525028)],
            [new Coordinate(56.836111, 60.598073)],
            [new Coordinate(56.797522, 60.456004)],
            [new Coordinate(56.699214, 60.642972)],
        ];
    }

    /**
     * @return array<array{Coordinate}>
     */
    public function outsideYekaterinburgCoordinateProvider(): array
    {
        return [
            [new Coordinate(56.782296, 60.375440)],
            [new Coordinate(56.808908, 60.808829)],
            [new Coordinate(56.954723, 60.592520)],
            [new Coordinate(56.863761, 60.317707)],
            [new Coordinate(56.920217, 60.761102)],
        ];
    }
}