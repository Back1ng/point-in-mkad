<?php

namespace Back1ng\PointInMkad;

use Geometry\Polygon;
use Location\Coordinate;
use Location\Distance\Vincenty;

class Detector
{
    private Coordinate $closestPoint;

    private float $distanceFromCenterToCoordinate;

    private float $distanceFromCenterToMkad;

    public function __construct(
        private readonly Coordinate $desiredCoordinate,
    ) {
        $moscowRingRoad = new MoscowRingRoad();

        $polygon = new Polygon($moscowRingRoad->getCoordinates());

        $calculator = new Vincenty();

        $centroid = $polygon->centroid();
        $centroid = new Coordinate(
            $centroid[1],
            $centroid[0],
        );

        $this->closestPoint = $this->calculateClosestPoint(
            $moscowRingRoad->getCoordinates(),
            $this->desiredCoordinate,
        );

        $this->distanceFromCenterToCoordinate = $calculator->getDistance(
            $centroid, $this->desiredCoordinate
        );

        $this->distanceFromCenterToMkad = $calculator->getDistance(
            $centroid, $this->closestPoint,
        );
    }

    public function getClosestPoint(): Coordinate
    {
        return $this->closestPoint;
    }

    public function isMkad(): bool
    {
        return $this->distanceFromCenterToCoordinate < $this->distanceFromCenterToMkad;
    }

    public function getDistanceFromMkadToCoordinate(): float
    {
        return (new Vincenty())->getDistance(
            $this->closestPoint, $this->desiredCoordinate,
        );
    }

    private function calculateClosestPoint(array $coordinates, Coordinate $desiredCoordinate): Coordinate
    {
        $calculator = new Vincenty();

        $minimalDistance = null;
        $closesPoint = null;

        foreach ($coordinates as $coordinate) {
            $distance = $calculator->getDistance(
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
}