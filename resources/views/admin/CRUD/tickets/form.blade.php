
{{-- Additional Buttton--}}

@if($entity->eurostar_ticket_number)
    {{-- IF REAL TICKET --}}
    @push('additional-btn')
        @if($entity->pdf_downloaded)
        <a class="btn btn-info btn-fill btn-sm mr-3" target="_blank" href="{{route('public.ticket.download',['ticket_id'=>$entity->id])}}">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download ticket
        </a>
        @else
        <button class="btn btn-info btn-fill btn-sm mr-3" type="button" disabled>
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download ticket
        </button>
        @endif
        <a class="btn btn-warning btn-fill btn-sm" href="{{route('tickets.redownload',['ticket_id'=>$entity->id])}}">
            <i class="fa fa-cloud-download" aria-hidden="true"></i> Retry donwloading ticket
        </a>
    @endpush
@endif

{{-- Fake ticket --}}
@if($entity->eurostar_ticket_number==null)
<div class="row text-bold">
    <div class="col">
    <h3 class="text-danger  text-center">FAKE</h3>
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

@if($entity->eurostar_ticket_number)
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
            <label>Eurostar Code</label>
            <input type="text" class="form-control" placeholder="Booking code"
                   value="{{$entity->eurostar_code}}" name="eurostar_code" disabled>
        </div>
    </div>
</div>

@else
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label><a href="{{route('trains.edit',['id'=>$entity->train->id])}}">Train Number</a></label>
                <input type="text" class="form-control" placeholder="Train number"
                       value="{{$entity->train->number}}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Departure city</label>
                <input type="text" class="form-control" name="departure_city" placeholder="Departure city"
                       value="{{$entity->train->departureCity->name}}" disabled="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Arrival city</label>
                <input type="text" class="form-control" name="arrival_city" placeholder="Arrival city"
                       value="{{$entity->train->arrivalCity->name}}" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Buyer Name</label>
                <input type="text" class="form-control" placeholder="Buyer last name"
                       value="{{$entity->buyer_name}}" name="buyer_name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Buyer Email</label>
                <input type="text" class="form-control" placeholder="Buyer email address"
                       value="{{$entity->buyer_email}}" name="buyer_email">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Eurostar Code</label>
                <input type="text" class="form-control" placeholder="Booking code"
                       value="{{$entity->eurostar_code}}" name="eurostar_code">
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Ticket Number</label>
            <input type="text" class="form-control"
                   value="{{$entity->eurostar_ticket_number}}" disabled>
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
            <userpicker :name="'user_id'"
                        :default-placeholder="'User name'"
                        :default-value="{{json_encode($entity->user)}}"></userpicker>
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
            </select>
        </div>
    </div>
</div>
