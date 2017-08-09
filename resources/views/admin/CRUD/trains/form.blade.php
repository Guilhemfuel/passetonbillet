<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Number</label>
            <input type="text" class="form-control" placeholder="Train number" value="{{isset($entity)?$entity->number:(old('number'))}}" name="number">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Departure Date</label>
            <datepicker :input-class="inputClass"
                        :wrapper-class="'lastar-calendar'"
                        :placeholder="'Departure Date'"
                        :name="'departure_date'"
                        :value="'{{isset($entity)?$entity->departure_date:(old('departure_date'))}}'"
            ></datepicker>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Departure Time</label>
            <phone :value="'{{isset($entity)?$entity->phone:(old('phone'))}}'"
                   :country-value="'{{isset($entity)?$entity->phone_country:(old('phone_country'))}}'"></phone>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{isset($entity)?$entity->email:(old('email'))}}">
        </div>
    </div>
</div>