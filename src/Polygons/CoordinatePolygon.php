<?php

namespace Back1ng\PointInMkad\Polygons;

use Geometry\Polygon;
use Location\Coordinate;

abstract class CoordinatePolygon
{
    /**
     * Because some problems, has reverse latitude and longitude
     *
     * Contains coordinates for some polygon
     * Example: [[1,0], [1,1], [0,1]]
     *
     * @return array
     */
    abstract public function get(): array;

    final public function isValid(): bool
    {
        $polygon = new Polygon($this->get());

        return $polygon->isValid();
    }

    final public function getCentroid(): Coordinate
    {
        $polygon = new Polygon($this->get());

        /** @var array<float> $centroid */
        $centroid = $polygon->centroid();

        return new Coordinate(
            $centroid[1],
            $centroid[0],
        );
    }
}
