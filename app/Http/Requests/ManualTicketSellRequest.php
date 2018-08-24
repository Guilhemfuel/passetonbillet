<?php

namespace App\Http\Requests;

use App\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class ManualTicketSellRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'travel_date'       => [ 'required', "date_format:d/m/Y", "after:yesterday" ],
            'train_number'      => [ 'required'  ],
            'departure_station' => [ 'required', "exists:stations,id", "different:arrival_station" ],
            'arrival_station'   => [ 'required', "exists:stations,id", "different:departure_station" ],
            'departure_time'    => [ 'required' ],
            'arrival_time'      => [ 'required' ],
            'company'           => [ 'required', "string", "in:" . implode( ",", Ticket::PROVIDERS ) ],
            'flexibility'       => [ 'required', "string" ],
            'classe'            => [ 'required', "string" ],
            'currency'          => [ 'required', "string", "in:EUR,USD,GBP" ],
            'bought_price'      => [ 'required', "numeric" ],
            'price'             => [ 'required', "numeric", "lte:bought_price" ],
        ];
    }
}
