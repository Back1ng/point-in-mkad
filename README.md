# point-in-mkad
Detect, if point in Moscow Ring Road (MKAD)

## Using:

```php
   <?php
   
   use Back1ng\PointInMkad\Detector;
   use Location\Coordinate;
   
   $desiredCoordinate = new Coordinate(55.720375, 37.639101);
   $detector = new Detector($desiredCoordinate);
   
   if ($detector->isMkad()) {
       // do smth...
   }
```

## Choose closest point of Mkad

To select the closest point from the Moscow Ring Road to yours, use the following method
```php
    <?php
    
     use Back1ng\PointInMkad\Detector;
     
     // creating detector...
     
     $detector->getClosestPoint(); // Will return Location\Coordinate
```

## You can also determine the distance from the Moscow Ring Road to your point, use the following code

This method uses the Vincents formula to calculate the distance in meters as accurately as possible

```php
    <?php
    
     use Back1ng\PointInMkad\Detector;
     
     // creating detector...
     
     $detector->getDistanceFromMkadToCoordinate(); // Will return float of distance in meters
```