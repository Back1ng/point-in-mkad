<?php

namespace Back1ng\PointInMkad;

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
            throw new \InvalidArgumentException('CoordinatePolygon class has no valid Polygon.');
        }
    }

    public function getClosestPoint(Coordinate $desiredCoordinate): Coordinate
    {
        $minimalDistance = null;
        $closesPoint = null;

        foreach ($this->coordinates->get() as $coordinate) {
            $distance = $this->calculator->getDistance(
                new Coordinate($coordinate[1], $coordinate[0]),
                $desiredCoordinate,
            );

            if (! isset($minimalDistance) || $distance < $minimalDistance) {
                $minimalDistance = $distance;
                $closesPoint = new Coordinate($coordinate[1], $coordinate[0]);
            }
        }

        return $closesPoint;
    }

    public function isPointInPolygon(Coordinate $desiredCoordinate): bool
    {
        $centroid = $this->coordinates->getCentroid();

        $distanceFromCenterToCoordinate = $this->calculator->getDistance(
            $centroid, $desiredCoordinate
        );

        $distanceFromCenterToOutlinePolygon = $this->calculator->getDistance(
            $centroid, $this->getClosestPoint($desiredCoordinate),
        );

        return $distanceFromCenterToCoordinate <= $distanceFromCenterToOutlinePolygon;
    }

    public function getDistanceFromOutlinePolygonToCoordinate(Coordinate $coordinate): float
    {
        return $this->calculator->getDistance(
            $this->getClosestPoint($coordinate), $coordinate,
        );
    }
}