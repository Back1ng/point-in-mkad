<?php

namespace Back1ng\PointInMkad;

use Back1ng\PointInMkad\Polygons\CoordinatePolygon;
use Back1ng\PointInMkad\Polygons\MoscowRingRoadPolygon;
use InvalidArgumentException;
use Location\Coordinate;
use Location\Distance\DistanceInterface;
use Location\Distance\Vincenty;

class Detector
{
    public function __construct(
        private readonly CoordinatePolygon $coordinates = new MoscowRingRoadPolygon(),
        private readonly DistanceInterface $calculator = new Vincenty(),
    ) {
        if (! $this->coordinates->isValid()) {
            throw new InvalidArgumentException(sprintf('%s class has no valid Polygon.', CoordinatePolygon::class));
        }
    }

    public function getClosestPoint(Coordinate $desiredCoordinate): Coordinate
    {
        /** @var array<float> $coordinate */
        foreach ($this->coordinates->get() as $coordinate) {
            $distance = $this->calculator->getDistance(
                new Coordinate($coordinate[1], $coordinate[0]),
                $desiredCoordinate,
            );

            if (! isset($minimalDistance) || $distance < $minimalDistance) {
                $minimalDistance = $distance;
                $closestPoint = new Coordinate($coordinate[1], $coordinate[0]);
            }
        }

        if (!isset($closestPoint)) {
            throw new InvalidArgumentException('Closest point not founded.');
        }

        /** @var Coordinate */
        return $closestPoint;
    }

    public function isPointInPolygon(Coordinate $desiredCoordinate): bool
    {
        $centroid = $this->coordinates->getCentroid();

        $distanceFromCenterToCoordinate = $this->calculator->getDistance(
            $centroid,
            $desiredCoordinate
        );

        $distanceFromCenterToOutlinePolygon = $this->calculator->getDistance(
            $centroid,
            $this->getClosestPoint($desiredCoordinate),
        );

        return $distanceFromCenterToCoordinate <= $distanceFromCenterToOutlinePolygon;
    }

    public function getDistanceFromOutlinePolygonToCoordinate(Coordinate $coordinate): float
    {
        return $this->calculator->getDistance(
            $this->getClosestPoint($coordinate),
            $coordinate,
        );
    }
}
