<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Eurostar Station Number</label>
            <input name="eurostar_id" type="text" class="form-control"
                   placeholder="Station number"
                   value="{{isset($entity)?$entity->eurostar_id:old('eurostar_id')}}" >
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Short name</label>
            <input name="short_name" type="text" class="form-control"
                   placeholder="Short Name"
                   value="{{isset($entity)?$entity->short_name:old('short_name')}}" >
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>French Name</label>
            <input name="name_fr" type="text" class="form-control"
                   placeholder="French Name"
                   value="{{isset($entity)?$entity->name_fr:old('name_fr')}}" >
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>English Name</label>
            <input name="name_en" type="text" class="form-control"
                   placeholder="English Name"
            value="{{isset($entity)?$entity->name_en:old('name_en')}}" >
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Country</label>
            <select name="country" class="form-control">
                <option value="fr">France</option>
                <option value="gb">United Kingdom</option>
                <option value="be">Belgium</option>
            </select>
        </div>
    </div>
</div>

