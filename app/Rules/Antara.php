<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Antara implements Rule
{
    private $min, $max;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->min == null || $this->max == null) {
            return false;
        }
        if ($value >= $this->min || $value <= $this->max) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->min == null || $this->max == null) {
            return 'Batasan :attribute tidak boleh dikosongi';
        }
        return 'Nilai :attribute harus diantara '.$this->min.' - '.$this->max;
    }
}
