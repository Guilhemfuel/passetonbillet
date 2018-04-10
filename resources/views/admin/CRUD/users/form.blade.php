@if($entity->fb_id)
    {{-- IF REAL TICKET --}}
    @push('additional-btn')
        <a class="btn btn-facebook btn-fill btn-sm pl-3" target="_blank" href="https://facebook.com/{{$entity->id}}">
            <i class="fa fa-facebook" aria-hidden="true"></i> Profile
        </a>
    @endpush
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>First Name @if($entity->id_verified) <i aria-hidden="true" class="fa fa-check-circle text-warning"></i> @endif</label>
            <input type="text" class="form-control" placeholder="First Name" value="{{isset($entity)?$entity->first_name:(old('first_name'))}}" name="first_name">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" placeholder="Last Name" value="{{isset($entity)?$entity->last_name:(old('last_name'))}}" name="last_name">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="gender">
                <option value="1" {{isset($entity)?($entity->gender==1?'selected':''):(old('gender')==1?'selected':'')}}>Male</option>
                <option value="0" {{isset($entity)?($entity->gender==0?'selected':''):(old('gender')==0?'selected':'')}}>Female</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Language</label>
            <select class="form-control" name="language">
                <option value="FR" {{isset($entity)?($entity->language=='FR'?'selected':''):(old('language')=='FR'?'selected':'')}}>French</option>
                <option value="EN" {{isset($entity)?($entity->language=='EN'?'selected':''):(old('gender')=='EN'?'selected':'')}}>English</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Birthdate</label>
            <datepicker input-class="form-control"
                        :wrapper-class="'lastar-calendar'"
                        :placeholder="'Birthdate'"
                        :name="'birthdate'"
                        :value="'{{isset($entity)?$entity->birthdate:(old('birthdate'))}}'"
            ></datepicker>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Phone</label>
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