<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class Country
 * @package App\Rules
 *
 * Make sure that field under validation is a correct country
 *
 */
class Country implements Rule
{
    public $name = 'country';

    protected $pathToJson = '../resources/assets/data/countries.json';

    protected $countries;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $string = file_get_contents(app_path($this->pathToJson));
        $json = json_decode($string, true);

        $this->countries = array_column($json,'code_iso3');
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
        return in_array($value,$this->countries);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid iso 3 formatted country.';
    }
}
