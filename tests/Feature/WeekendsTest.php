<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeekendsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $weekendObj = new \App\Weekends('2020-10-01', '2020-10-31');

        $outputFile = $weekendObj->calculateAndGenerateOutput();
        $fileHandle = fopen($outputFile, 'r');
        $output = fread($fileHandle, filesize($outputFile));

        $this->assertEquals(
            '4',
            $output
        );

        $weekendObj = new \App\Weekends('10/11/2020', '20201001');
        $outputFile = $weekendObj->calculateAndGenerateOutput();
        $fileHandle = fopen($outputFile, 'r');
        $output = fread($fileHandle, filesize($outputFile));

        $this->assertEquals(
            'invalid date',
            $output
        );
    }
}
