<?php

namespace App\Services;


class GeoMapper
{
    private $longitude_from, $latitude_from, $longitude_to, $latitude_to;
    private $distance_calculation_method = 'HAVERSINE_FORMULA';

    const KILOMETER = 'km';
    const METER = 'm';

    function __construct()
    {
    }

    /*
    Used to set distance calculation method (for example HAVERSINE_FORMULA, GOOGLEMAP etc..)
    */
    public function setDistanceCalculationMethod($method)
    {
        $this->distance_calculation_method = $method;
    }

    /*
    Used to set longitude and latitude locations
    */
    public function setLocations($longitude_from, $latitude_from, $longitude_to, $latitude_to)
    {
        $this->longitude_from = $longitude_from;
        $this->latitude_from = $latitude_from;
        $this->longitude_to = $longitude_to;
        $this->latitude_to = $latitude_to;
    }

    /*
    Calculate shortest distance
    */
    // public function calculateShortDistance($distance_in = SELF::METER)
    // {
    //     $longitude_from = deg2rad($this->longitude_from);
    //     $latitude_from = deg2rad($this->latitude_from);
    //     $longitude_to = deg2rad($this->longitude_to);
    //     $latitude_to = deg2rad($this->latitude_to);

    //     if (($longitude_from == $longitude_to) && ($latitude_from == $latitude_to)) {
    //         return 0;
    //     } else {
    //         $distance_longitude = $longitude_to - $longitude_from;
    //         $distance_latitude = $latitude_to - $latitude_from;

    //         $value = pow(sin($distance_latitude / 2), 2) +
    //             cos($latitude_from) * cos($latitude_to) *
    //             pow(sin($distance_longitude / 2), 2);

    //         $result = 2 * asin(sqrt($value));
    //         $radius = 3958.756;

    //         //distance in miles
    //         $distance = $result * $radius;

    //         if ($distance_in == SELF::KILOMETER) {
    //             $distance = $this->getDistanceInKM($distance);
    //         }

    //         if ($distance_in == SELF::METER) {
    //             $distance = $this->getDistanceInM($distance);
    //         }

    //         return $distance;
    //     }
    // }

    function calculateDistance($latitude_to, $longitude_to, $latitude_from, $longitude_from)
    {
        $theta = $longitude_to - $longitude_from;
        $miles = (sin(deg2rad($latitude_to))) * sin(deg2rad($latitude_from)) + (cos(deg2rad($latitude_to)) * cos(deg2rad($latitude_from)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $result = $miles * 60 * 1.1515;
        $distance = $result * 1.609344;
        // $result['feet'] = $result['miles']*5280;
        // $result['yards'] = $result['feet']/3;
        // $result['kilometers'] = $result['miles']*1.609344;
        // $result['meters'] = $result['kilometers']*1000;
        return $distance;
    }

    /*
    Get distance in kilometers
    */
    public function getDistanceInKM($distance)
    {
        return round($distance * 1.609344, 2);
    }

    /*
    Get distance in meters
    */
    public function getDistanceInM($distance)
    {
        return round($distance * 1609.34, 2);
    }
}

//references 
//- https://www.geeksforgeeks.org/program-distance-two-points-earth/
