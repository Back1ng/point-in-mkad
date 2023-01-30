# point-in-mkad
Detect, if point in polygon, by default - in Moscow Ring Road (MKAD)
<br>

Available polygons: 

<ul>
    <li>Moscow Ring Road</li> 
    <li>St. Petersburg Ring Road.</li>
    <li>Yekaterinburg Ring Road.</li>
</ul>

## Using:

```php
   <?php
   
   use Back1ng\PointInMkad\Detector;
   use Location\Coordinate;
   
   $detector = new Detector();
   $desiredCoordinate = new Coordinate(55.720375, 37.639101);
   
   if ($detector->isPointInPolygon($desiredCoordinate)) {
       // do smth...
   }
```

## Choose closest point of polygon

To select the closest point from the Moscow Ring Road to yours, use the following method
```php
    <?php
    
    use Back1ng\PointInMkad\Detector;
    
    // creating detector...
    
    $detector->getClosestPoint($desiredCoordinate); // Will return Location\Coordinate
```

## You can also determine the distance from the outline polygon to your point

This method uses the implementation of calculator (<b>Vincents formula</b> by default),
to calculate the distance in meters as accurately as possible

```php
    <?php
    
    use Back1ng\PointInMkad\Detector;
    
    // creating detector...
    
    $detector->getDistanceFromOutlinePolygonToCoordinate($desiredCoordinate): float;
```

## Implementing your own polygon

Need to create a class from ```Back1ng\PointInMkad\CoordinatePolygon``` 
and override parent method ```get()```

```php
    <?php

    use Back1ng\PointInMkad\Polygons\CoordinatePolygon;

    class CustomPolygon extends CoordinatePolygon
    {
        public function get(): array
        {
            return [
                [1, 0],
                [1, 1],
                [0, 1],
            ]
        }
    }
```

Then you can validate this polygon and get centroid.

```php
    $polygon = new CustomPolygon();

    $polygon->isValid(); // true
    $polygon->getCentroid(); // Location\Coordinate
```

How to use new polygon?
```php
    $polygon = new CustomPolygon();

    $detector = new \Back1ng\PointInMkad\Detector(coordinates: $polygon);
```