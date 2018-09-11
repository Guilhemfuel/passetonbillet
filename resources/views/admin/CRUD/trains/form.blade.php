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
            <input-station name="departure_city"
                           label="Departure city"
                           validation="required"
                           :with-icon="false"
                           default-value="{{isset($entity)?$entity->departure_city:(old('departure_city'))}}"
            ></input-station>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <input-station name="arrival_city"
                           label="Arrival city"
                           validation="required"
                           :with-icon="false"
                           default-value="{{isset($entity)?$entity->arrival_city:(old('arrival_city'))}}"
            ></input-station>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input-date
                    name="departure_date"
                    label="Departure Date"
                    validation="date_format:DD/MM/YYYY"
                    placeholder="DD/MM/YYYY"
                    format="dd/MM/yyyy"
                    value-format="dd/MM/yyyy"
                    default-value="{{isset($entity)&&$entity->departure_date!=null?$entity->departure_date->format('d/m/Y'):(old('departure_date'))}}"
                    default-value-format="DD/MM/YYYY"></input-date>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <input-date
                    name="arrival_date"
                    label="Arrival Date"
                    validation="date_format:DD/MM/YYYY"
                    placeholder="DD/MM/YYYY"
                    format="dd/MM/yyyy"
                    value-format="dd/MM/yyyy"
                    default-value="{{isset($entity)&&$entity->arrival_date!=null?$entity->arrival_date->format('d/m/Y'):(old('arrival_date'))}}"
                    default-value-format="DD/MM/YYYY"></input-date>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input-time name="departure_time"
                        label="Departure time"
                        placeholder="12:00"
                        validation="required"
                        default-value="{{isset($entity)?$entity->departure_time:(old('departure_time'))}}"
            ></input-time>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <input-time name="arrival_time"
                        label="Arrival Time"
                        placeholder="12:00"
                        validation="required"
                        default-value="{{isset($entity)?$entity->arrival_time:(old('arrival_time'))}}"
            ></input-time>
        </div>
    </div>
</div>
