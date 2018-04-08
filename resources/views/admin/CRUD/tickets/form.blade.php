
<div class="row text-bold">
    <div class="col">
    <h3 class="text-danger  text-center">{{$entity->eurostar_ticket_number==null?'FAKE':''}}</h3>
    </div>
</div>
@if($entity->eurostar_ticket_number)
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Train Number</label>
            <input type="text" class="form-control" name="departure_city" placeholder="Train number"
                   value="{{$entity->train->number}}" disabled>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Departure city</label>
            <input type="text" class="form-control" name="departure_city" placeholder="Departure city"
                   value="{{$entity->train->departureCity->name}}" disabled>
        </div>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-6">
        <div class="form-group">
            <label>Trip</label>
            <select class="form-control" name="inbound" disabled>
                <option value="true" {{$entity->inbound?'selected':''}}>Inbound</option>
                <option value="false" {{!$entity->inbound?'selected':''}}>Outbound</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>User</label>
            <userpicker :name="'user_id'"
                        :default-placeholder="'User name'"
                        :default-value="{{json_encode($entity->user)}}"></userpicker>
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
