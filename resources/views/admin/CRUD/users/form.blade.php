@if($entity->banned)
    <h4 class="text-danger text-center">BANNED</h4>
@else
    @push('additional-btn')
        <a class="btn btn-danger btn-fill btn-sm ml-3" href="{{route('users.ban',$entity->id)}}">
            <i class="fa fa-ban" aria-hidden="true"></i>
            Ban User
        </a>
    @endpush
@endif

@if($entity->fb_id)
    {{-- IF Facebook user --}}
    @push('additional-btn')
        <a class="btn btn-facebook btn-fill btn-sm ml-3" target="_blank" href="https://facebook.com/{{$entity->fb_id}}">
            <i class="fa fa-facebook" aria-hidden="true"></i> Profile
        </a>
    @endpush
@endif


{{-- Impersonnate if not banned --}}
@if(!$entity->banned)
    @push('additional-btn')
        <a class="btn btn-warning btn-fill btn-sm ml-3" href="{{route('users.impersonate',$entity->id)}}">
            <i class="fa fa-magic pr-2" aria-hidden="true"></i> Impersonate
        </a>
    @endpush
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>First Name @if($entity->id_verified) <i aria-hidden="true"
                                                           class="fa fa-check-circle text-warning"></i> @endif</label>
            <input type="text" class="form-control" placeholder="First Name"
                   value="{{isset($entity)?$entity->first_name:(old('first_name'))}}" name="first_name">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" placeholder="Last Name"
                   value="{{isset($entity)?$entity->last_name:(old('last_name'))}}" name="last_name">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="gender">
                <option value="1" {{isset($entity)?($entity->gender==1?'selected':''):(old('gender')==1?'selected':'')}}>
                    Male
                </option>
                <option value="0" {{isset($entity)?($entity->gender==0?'selected':''):(old('gender')==0?'selected':'')}}>
                    Female
                </option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Language</label>
            <select class="form-control" name="language">
                <option value="FR" {{isset($entity)?($entity->language=='FR'?'selected':''):(old('language')=='FR'?'selected':'')}}>
                    French
                </option>
                <option value="EN" {{isset($entity)?($entity->language=='EN'?'selected':''):(old('gender')=='EN'?'selected':'')}}>
                    English
                </option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input-date
                    name="birthdate"
                    class-name="col-xs-12"
                    label="Birthdate"
                    validation="date_format:DD/MM/YYYY"
                    placeholder="DD/MM/YYYY"
                    format="dd/MM/yyyy"
                    value-format="dd/MM/yyyy"
                    default-value="{{isset($entity)?$entity->birthdate:(old('birthdate'))}}"
                    default-value-format="DD/MM/YYYY"></input-date>
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
            <input type="text" class="form-control" placeholder="Email" name="email"
                   value="{{isset($entity)?$entity->email:(old('email'))}}">
        </div>
    </div>
</div>


{{------------ Additional content --------------}}

@push('additional-content')

    <div class="row mt-5">
        <div class="col-sm-6 col-12">
            <h5>Emails Sents({{$entity->emailsReceived()->count()}})</h5>
            <table class="table table-hover table-striped">
                <thead>
                <th>Type</th>
                <th class="text-center">Ticket</th>
                <th class="text-right">Date</th>
                </thead>
                <tbody>
                @foreach($entity->emailsReceived as $email)
                    <tr>
                        <td>{{$email->email_class}}</td>
                        <th class="text-center">
                            @if($email->ticket_id)
                                <a href="{{route('tickets.edit',$email->ticket_id)}}"><i class="fa fa-ticket"></i></a>
                            @else
                                -
                            @endif
                        </th>
                        <td class="text-right">{{$email->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-sm-6 col-12">
            <h5>Tickets({{$entity->tickets()->count()}})</h5>
            <table class="table table-hover table-striped">
                <thead>
                <th>Date</th>
                <th>From</th>
                <th>To</th>
                <th>Price</th>
                <th>Link</th>
                </thead>
                <tbody>
                @foreach($entity->tickets as $ticket)
                    <tr>
                        <td>{{$ticket->train->carbon_departure_date->format('d/m/Y')}}</td>
                        <th>
                            {{substr($ticket->train->departureCity->short_name,2)}}
                        </th>
                        <th>
                            {{ substr($ticket->train->arrivalCity->short_name,2)  }}
                        </th>
                        <th>
                            {{$ticket->price}} {{$ticket->currency}}
                        </th>
                        <th>
                            <a href="{{route('tickets.edit',$ticket->id)}}"><i class="fa fa-ticket"></i></a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endpush