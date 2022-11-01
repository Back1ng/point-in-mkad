<?php

namespace Back1ng\Tests\Fixtures;

use Back1ng\PointInMkad\Polygons\CoordinatePolygon;

class FixtureCustomPolygon extends CoordinatePolygon
{
    public function get(): array
    {
        return [
            [1, 0],
            [1, 1],
            [0, 1],
        ];
    }
}