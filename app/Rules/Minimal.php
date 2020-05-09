<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Minimal implements Rule
{
    private $min;
    private $kosong = false;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($min)
    {
        $this->min = $min;
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
        if ($this->min == null) {
            $this->kosong = true;
        } else {
            if ($value >= $this->min) {
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
            return 'Nilai batasan minimal tidak boleh kosong';
        } else {
            return 'Nilai :attribute minimal '.$this->min;
        }

    }
}
