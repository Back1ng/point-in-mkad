<?php

namespace Back1ng\Tests;

use Back1ng\PointInMkad\Detector;
use Back1ng\Tests\Fixtures\FixtureCustomPolygon;
use Back1ng\Tests\Fixtures\FixtureIncorrectPolygon;
use Location\Coordinate;
use Location\Distance\Haversine;
use PHPUnit\Framework\TestCase;

class CustomPolygonTest extends TestCase
{
    public function testDetectCentroid()
    {
        $polygon = new FixtureCustomPolygon();

        $this->assertEquals(
            new Coordinate(0.6666666666666666, 0.6666666666666666),
            $polygon->getCentroid()
        );
    }

    public function testCustomPolygonIsValid()
    {
        $polygon = new FixtureCustomPolygon();

        $this->assertTrue($polygon->isValid());
    }

    public function testIncorrectPolygonIsNotValid()
    {
        $polygon = new FixtureIncorrectPolygon();

        $this->assertFalse($polygon->isValid());
    }

    public function testDetectorCanUseAnotherCalculator()
    {
        $detector = new Detector(
            coordinates: new FixtureCustomPolygon(),
            calculator: new Haversine(),
        );

        $this->assertTrue($detector->isPointInPolygon(new Coordinate(1, 1)));
    }
}