@extends('admin.CRUD.create')

@section('form')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="First Name" value="" name="first_name">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name" value="" name="last_name">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Gender</label>
                <select class="form-control" name="gender">
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Language</label>
                <select class="form-control" name="language">
                    <option value="1">French</option>
                    <option value="0">English</option>
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
                            :name="'birthdate'"></datepicker>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Phone Country</label>
                <select class="form-control">
                    <option value="FR">FR</option>
                    <option value="GB">GB</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone Number</label>
                <cleave type="text"
                        name="phone"
                        class="form-control"
                        placeholder="Phone Number"
                        :options="{phone: true,phoneRegionCode: 'FR'}"
                        value=""></cleave>
            </div>
        </div>
    </div>

@endsection