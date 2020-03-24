<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Maximal implements Rule
{
    private $max;
    private $kosong = false;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max)
    {
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
        if ($this->max == null) {
            $this->kosong = true;
        } else {
            if ($value <= $this->max) {
                return true;
            } else {
                return false;
            }
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->kosong) {
            return 'Nilai batasan maximal tidak boleh kosong';
        } else {
            return 'Nilai :attribute harus dibawah '.$this->max;
        }
    }
}
