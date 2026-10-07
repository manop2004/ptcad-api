<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkProductRecommend implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $checkRequest = count($value);

        if ($checkRequest < 5) {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'คุณเลือกสินค้าเกินที่กำหนด.';
    }
}
