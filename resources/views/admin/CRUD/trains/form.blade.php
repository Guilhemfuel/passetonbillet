<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Number</label>
            <input type="text" class="form-control" placeholder="Train number"
                   value="{{isset($entity)?$entity->number:(old('number'))}}" name="number">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Departure city</label>
            <stationpicker :name="'departure_city'"
                           :default-value="'1'"></stationpicker>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Arrival city</label>
            <stationpicker :name="'arrival_city'"
                           :default-value="'{{isset($entity)?$entity->arrival_city:(old('arrival_city'))}}'"></stationpicker>
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
                        :selected-item="'{{isset($entity)?$entity->departure_date:(old('departure_date'))}}'"
            ></datepicker>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Arrival Date</label>
            <datepicker :input-class="inputClass"
                        :wrapper-class="'lastar-calendar'"
                        :placeholder="'Departure Date'"
                        :name="'arrival_date'"
                        :selected-item="'{{isset($entity)?$entity->arrival_date:(old('arrival_date'))}}'"
            ></datepicker>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Departure Time</label>
            <timepicker :name="'departure_time'"
                        :value="'{{isset($entity)?$entity->departure_time:(old('departure_time'))}}'"
                        :placeholder="'Departure time'"></timepicker>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Arrival Time</label>
            <timepicker :name="'arrival_time'"
                        :value="'{{isset($entity)?$entity->arrival_time:(old('arrival_time'))}}'"
                        :placeholder="'Arrival time'"
            ></timepicker>
        </div>
    </div>
</div>
