<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Fridge;
class NotEnoughProducts implements Rule
{

    public function __construct()
    {
        
    }
   
    public function passes($attribute, $value)
    {
        
    }

    public function message()
    {
        return 'Some Products are not enough';
    }
}
