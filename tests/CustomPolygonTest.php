<?php declare(strict_types=1);

namespace Back1ng\Tests;

use Back1ng\PointInMkad\Detector;
use Back1ng\Tests\Fixtures\FixtureCustomPolygon;
use Back1ng\Tests\Fixtures\FixtureIncorrectPolygon;
use Location\Coordinate;
use Location\Distance\Haversine;
use PHPUnit\Framework\TestCase;

final class CustomPolygonTest extends TestCase
{
    public function testDetectCentroid(): void
    {
        $polygon = new FixtureCustomPolygon();

        $this->assertEquals(
            new Coordinate(0.6666666666666666, 0.6666666666666666),
            $polygon->getCentroid()
        );
    }

    public function testCustomPolygonIsValid(): void
    {
        $polygon = new FixtureCustomPolygon();

        $this->assertTrue($polygon->isValid());
    }

    public function testIncorrectPolygonIsNotValid(): void
    {
        $polygon = new FixtureIncorrectPolygon();

        $this->assertFalse($polygon->isValid());
    }

    public function testDetectorCanUseAnotherCalculator(): void
    {
        $detector = new Detector(
            coordinates: new FixtureCustomPolygon(),
            calculator: new Haversine(),
        );

        $this->assertTrue($detector->isPointInPolygon(new Coordinate(1, 1)));
    }
}