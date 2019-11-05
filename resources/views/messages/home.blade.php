@extends('layouts.dashboard')

@section('title')
    - Messages
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="messages-home">
            <messages-home :lang="child.messages_home.lang"
                           :routes="child.messages_home.routes"
                           :ticket-lang="child.messages_home.ticketLang"
                           ></messages-home>
        </div>
    </div>
@endsection

<?php
$lang = Lang::get( 'message' );
$routes = [
    'deny_offer' => route('public.message.offer.deny'),
    'accept_offer' => route('public.message.offer.accept'),
    'discussion' => route('public.message.discussion.page',['ticket_id','discussion_id'])
];
?>

@push('vue-data')
    <script type="text/javascript">
        data.messages_home = {
            lang: {!!json_encode($lang)!!},
            routes: {!! json_encode($routes) !!},
        }
    </script>
@endpush
