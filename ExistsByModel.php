<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistsByModel implements ValidationRule
{

    protected $className;
    protected $column;

    public function __construct($className, $column = 'id')
    {
        $this->className = $className;
        $this->column = $column;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $count = $this->className::query()->where($this->column, $value)->count();
        if($count == 0){
            $fail('The :attribute not found.');
        }
    }
}
