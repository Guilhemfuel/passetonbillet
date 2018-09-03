
{{-- Additional Buttton--}}
@push('additional-btn')
    @if(!$entity->scam)
    <a class="btn btn-danger btn-fill btn-sm mr-3" href="{{route('tickets.scam',$entity->id)}}">
        <i class="fa fa-ban" aria-hidden="true"></i>
        Mark as Scam
    </a>
    @endif
@endpush

@if($entity->scam)
    <div class="row text-bold">
        <div class="col">
            <h3 class="text-danger  text-center">SCAM</h3>
        </div>
    </div>
@elseif($entity->sold_to_id!=null)
<div class="row text-bold">
    <div class="col">
        <h3 class="text-success  text-center">SOLD</h3>
    </div>
</div>
@endif

{{-- Form --}}

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label><a href="{{route('trains.edit',$entity->train->id)}}">Train Number</a></label>
            <input type="text" class="form-control" name="train_number" placeholder="Train number"
                   value="{{$entity->train->number}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Departure Date</label>
            <input type="text" class="form-control" placeholder="Train number"
                   value="{{$entity->train->carbon_departure_date->format('d/m/Y H:i:s')}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Departure city</label>
            <input type="text" class="form-control" name="departure_city" placeholder="Departure city"
                   value="{{$entity->train->departureCity->name}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Arrival city</label>
            <input type="text" class="form-control"  name="arrival_city" placeholder="Arrival city"
                   value="{{$entity->train->arrivalCity->name}}" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Buyer Name</label>
            <input type="text" class="form-control" placeholder="Buyer last name"
                   value="{{$entity->buyer_name}}" name="buyer_name" disabled>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Buyer Email</label>
            <input type="text" class="form-control" placeholder="Buyer email address"
                   value="{{$entity->buyer_email}}" name="buyer_email" disabled>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Booking Code</label>
            <input type="text" class="form-control" placeholder="Booking code"
                   value="{{$entity->provider_code}}" name="provider_code" disabled>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Ticket Number</label>
            <input type="text" class="form-control"
                   value="{{$entity->ticket_number}}" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Trip</label>
            <select class="form-control" name="inbound" disabled>
                <option value="true" {{$entity->inbound?'selected':''}}>Inbound</option>
                <option value="false" {{!$entity->inbound?'selected':''}}>Outbound</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Seller</label>
            @if(!$entity->scam)
            <userpicker :name="'user_id'"
                        :default-placeholder="'User name'"
                        :default-value="{{json_encode($entity->user)}}"></userpicker>
            @else
                <input type="text" class="form-control"
                       value="{{$entity->user->full_name}}" disabled>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Buyer</label>
            <input type="text" class="form-control"
                   value="{{isset($entity->buyer)?$entity->buyer->full_name:''}}" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Bought price</label>
            <input class="form-control" value="{{$entity->bought_price}}" name="bought_price" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Bought currency</label>
            <select class="form-control" name="bought_currency">
                <option value="GBP" {{$entity->bought_currency=='GBP'?'selected':''}}>GBP</option>
                <option value="EUR" {{$entity->bought_currency=='EUR'?'selected':''}}>EUR</option>
                <option value="EUR" {{$entity->bought_currency=='EFT'?'selected':''}}>EFT</option>
                <option value="EUR" {{$entity->bought_currency=='USD'?'selected':''}}>USD</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Selling price</label>
            <input class="form-control" value="{{$entity->price}}" name="price"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Selling currency</label>
            <select class="form-control" name="currency">
                <option value="GBP" {{$entity->currency=='GBP'?'selected':''}}>GBP</option>
                <option value="EUR" {{$entity->currency=='EUR'?'selected':''}}>EUR</option>
                <option value="EUR" {{$entity->currency=='EFT'?'selected':''}}>EFT</option>
                <option value="EUR" {{$entity->currency=='USD'?'selected':''}}>USD</option>
            </select>
        </div>
    </div>
</div>


{{------------ Additional content --------------}}

@push('additional-content')

    <div class="row mt-5">
        <div class="col-sm-6 col-12">
            <h5>Offers ({{$entity->discussions()->count()}})</h5>
            <table class="table table-hover table-striped">
                <thead>
                <th>Date</th>
                <th>From</th>
                <th>Price</th>
                <th>Status</th>
                <th>Link</th>
                </thead>
                <tbody>
                @foreach($entity->discussions as $offer)
                    <tr>
                        <td>{{$offer->created_at->format('d/m/Y')}}</td>
                        <td>
                            {{$offer->buyer->full_name}}
                        </td>
                        <td>
                            {{$offer->price}} {{$offer->currency}}
                        </td>
                        <td>
                            {{$offer->status_text}}
                        </td>
                        <td>
                            <a href="{{route('offers.edit',$offer->id)}}"><i class="fa fa-comments" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endpush
