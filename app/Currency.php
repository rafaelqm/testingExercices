<?php


namespace App;


class Currency
{
    /**
     * multiply
     *
     * @param float $number1
     * @param float $number2
     *
     * @return string
     */
    public function multiply(float $number1, float $number2): string
    {
        return bcmul($number1, $number2, 2);
    }

    /**
     * division
     *
     * @param float $number1
     * @param float $number2
     *
     * @return string
     */
    public function division(float $number1, float $number2): string
    {
        if ($number2 == 0) {
            return false;
        }

        return bcdiv($number1, $number2, 2);
    }

    /**
     * sum
     *
     * @param $number1
     * @param $number2
     *
     * @return string
     */
    public function sum($number1, $number2)
    {
        return bcadd($number1, $number2, 2);
    }

    /**
     * subtract
     *
     * @param $number1
     * @param $number2
     *
     * @return string
     */
    public function subtract($number1, $number2)
    {
        return bcsub($number1, $number2, 2);
    }

    /**
     * @param $inputNumber1
     * @param $inputFormat1
     * @param $inputNumber2
     * @param $inputFormat2
     * @param $operation
     * @return string
     */
    public function calculate(
        string $inputNumber1,
        string $inputFormat1,
        string $inputNumber2,
        string $inputFormat2,
        string $operation
    ): string {
        if (!method_exists($this, $operation)) {
            return 'invalid operation';
        }
        $numberFormated1 = $this->returnDecimalFormated($inputNumber1, $inputFormat1);
        $numberFormated2 = $this->returnDecimalFormated($inputNumber2, $inputFormat2);

        return $this->$operation($numberFormated1, $numberFormated2);
    }

    /**
     * returnDecimalFormated
     *
     * @param $number
     * @param $format
     *
     * @return string
     */
    private function returnDecimalFormated($number, $format)
    {
        $numberFormated = new \NumberFormatter(
            $format,
            \NumberFormatter::DECIMAL
        );
        return $numberFormated->parse($number);
    }
}
