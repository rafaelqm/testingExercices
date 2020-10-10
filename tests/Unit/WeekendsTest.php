<?php

namespace Tests\Unit;

use App\Weekends;
use PHPUnit\Framework\TestCase;

class WeekendsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCalculateWeekendsBetweenDates()
    {
        $weekendObj = new Weekends('2020-10-01', '2020-10-31');
        $output = $weekendObj->calculateWeekendsBetweenDates();
        $this->assertEquals(
            4,
            $output
        );

        // Inverse date order
        $weekendObj = new Weekends('2020-10-31', '2020-10-01');
        $output = $weekendObj->calculateWeekendsBetweenDates();
        $this->assertEquals(
            4,
            $output
        );

        // Invalid Date
        $weekendObj = new Weekends('10/11/2020', '20201001');
        $output = $weekendObj->calculateWeekendsBetweenDates();

        $this->assertEquals(
            false,
            $output
        );
    }
}
