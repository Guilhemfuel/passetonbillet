@extends('admin.layouts.app')

@section('title')
    - ID Verification
@endsection

@section('content')

    <div id="unique-admin" class="id-verification">
        <div class="card">
            <div class="card-header">
                <h5>Id Verification</h5>
            </div>

            <div class="card-body">

                <h4>User Details:</h4>
                <div class="row user-info">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <p>Full Name: <a target="_blank" href="{{route('users.edit',$user->id)}}">{{$user->full_name}}</a></p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <p>Birthdate: {{$user->birthdate}}</p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <p>Location: {{$user->location?:'-'}}</p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <img class="img-fluid" src="{{$user->picture}}" alt="user_pp"/>
                    </div>
                </div>
                <h4>Uploaded Id:</h4>
                <div class="row">
                    <div class="col">
                    @if(!$user->idVerification->is_pdf)
                    <img class="mx-auto id-scan" src="{{$user->idVerification->scan}}"/>
                    @else
                    <embed src="{{$user->idVerification->scan}}" class="mx-auto id-scan" width="100%" height="400">
                    @endif
                    </div>
                </div>


                <div class="btn-rack mt-5 action-buttons">
                    <form method="post" action="{{route('id_check.accept')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="verification_id" value="{{$user->idVerification->id}}">
                        <button type="submit" class="btn btn-success">Accept ID Verification</button>
                    </form>
                    <button @click.prevent="child.id_check.denyModalOpened=true" class="btn btn-danger">Deny ID Verification</button>
                </div>

                <modal v-cloak :is-open="child.id_check.denyModalOpened" @close-modal="child.id_check.denyModalOpened=false" title="Deny ID Verification">
                    <form method="post" action="{{route('id_check.deny')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="verification_id" value="{{$user->idVerification->id}}">
                        <textarea class="form-control" placeholder="Reasons to deny ID verification" name="comment"></textarea>
                        <button class="btn btn-danger btn-block mt-3" type="submit">Deny ID verification</button>
                    </form>
                </modal>

            </div>
        </div>
    </div>

@endsection

@push('vue-data')
    <script type="application/javascript">
        data.id_check = {
            denyModalOpened: false
        }
    </script>
@endpush