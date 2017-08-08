<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" class="form-control" placeholder="First Name" value="{{old('first_name')}}" name="first_name">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" placeholder="Last Name" value="{{old('last_name')}}" name="last_name">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="gender">
                <option value="1" {{old('gender')==1?'selected':''}}>Male</option>
                <option value="0" {{old('gender')==0?'selected':''}}>Female</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Language</label>
            <select class="form-control" name="language">
                <option value="FR" {{old('gender')=='FR'?'selected':''}}>French</option>
                <option value="EN" {{old('gender')=='EN'?'selected':''}}>English</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Birthdate</label>
            <datepicker :input-class="inputClass"
                        :wrapper-class="'lastar-calendar'"
                        :placeholder="'Birthdate'"
                        :name="'birthdate'"
                        :value="'{{old('birthdate')}}'"
            ></datepicker>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Phone</label>
            <phone :value="'{{old('phone')}}'"></phone>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" placeholder="Email" name="email">
        </div>
    </div>
</div>