<?php


namespace App;


use Carbon\Carbon;
use Illuminate\Support\Str;

class Weekends
{
    private $dateOne;
    private $dateTwo;
    private $outputName;

    public function __construct(string $date1, string $date2)
    {
        $this->dateOne = $this->treatStringDate($date1);
        $this->dateTwo = $this->treatStringDate($date2);
        $this->outputName = Str::of($date1 . $date2)->slug('_');
    }

    /**
     * treatStringDate
     *
     * @param string $date
     * @return Carbon|null
     */
    private function treatStringDate(string $date)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Exception $e) {
            $date = null;
        }

        return $date;
    }

    /**
     * calculateAndGenerateOutput
     *
     * @return string filepath
     */
    public function calculateAndGenerateOutput()
    {
        $weekends = $this->calculateWeekendsBetweenDates();
        if ($weekends === false) {
            return $this->generateOutput('invalid date');
        }
        return $this->generateOutput($weekends);
    }

    /**
     * calculateWeekendsBetweenDates
     *
     * @return int
     */
    public function calculateWeekendsBetweenDates()
    {
        if (is_null($this->dateOne) || is_null($this->dateTwo)) {
            return false;
        }

        if ($this->dateOne->greaterThan($this->dateTwo)) {
            $temp = $this->dateOne;
            $this->dateOne = $this->dateTwo;
            $this->dateTwo = $temp;
        }

        $weekend_days = $this->dateOne->diffInDaysFiltered(
            function (Carbon $date) {
                return $date->isWeekend();
            },
            $this->dateTwo
        );

        $weekends = 0;
        if ($weekend_days) {
            $weekends = intval(floor($weekend_days / 2));
        }

        return $weekends;
    }

    /**
     * generateOutput
     *
     * @param $weekends_amount
     *
     * @return string
     */
    private function generateOutput($weekends_amount)
    {
        $file_path = storage_path('app/public/' . $this->outputName . '.txt');

        $file = fopen($file_path, 'w+');
        fwrite($file, $weekends_amount);
        fclose($file);

        return $file_path;
    }
}
