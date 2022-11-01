<?php

namespace Back1ng\Tests\Fixtures;

use Back1ng\PointInMkad\Polygons\CoordinatePolygon;

class FixtureIncorrectPolygon extends CoordinatePolygon
{
    public function get(): array
    {
        return [
            [1, 0],
            [1, 1],
        ];
    }
}