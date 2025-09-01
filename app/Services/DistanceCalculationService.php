<?php

namespace App\Services;

class DistanceCalculationService
{
    /**
     * Calculate distance between two coordinates using Haversine formula
     *
     * @param float $lat1 Store latitude
     * @param float $lon1 Store longitude
     * @param float $lat2 Delivery address latitude
     * @param float $lon2 Delivery address longitude
     * @return float Distance in kilometers
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Earth radius in kilometers
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return round($distance, 2);
    }
}
