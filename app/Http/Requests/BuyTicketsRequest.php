<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyTicketsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure_station' => 'required|integer|exists:stations,id',
            'arrival_station' => 'required|integer|exists:stations,id',
            'trip_date' => 'required|date_format:d/m/Y|after:yesterday',
        ];
    }
}
