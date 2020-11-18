<?php

namespace App\Tests\Utils;

use App\Utils\GeoCalculator;
use PHPUnit\Framework\TestCase;

class GeoCalculatorTest extends TestCase
{
    public function testGetDistanceBetweenPoints()
    {
        $calculator = new GeoCalculator;
        $distance = round($calculator->getDistanceBetweenPoints(45.369881, 5.585163, 45.369881, 5.585163), 1);
        $this->assertEquals(0.0, $distance);
        $distance = round($calculator->getDistanceBetweenPoints(45.369881, 5.585163, 45.182151, 5.727472), 1);
        $this->assertEquals(23.7, $distance);
        $distance = round($calculator->getDistanceBetweenPoints(45.757814, 4.832011, 45.696535, 4.944164), 1);
        $this->assertEquals(11.1, $distance);
        $distance = round($calculator->getDistanceBetweenPoints(45.566267, 5.920364, 45.182151, 5.727472), 1);
        $this->assertEquals(45.3, $distance);
    }
}
