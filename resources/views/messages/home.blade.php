@extends('layouts.dashboard')

@section('title')
    - Messages
@endsection

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="messages-home">
            <messages-home :lang="child.messages_home.lang"
                           :user="child.messages_home.user"
                           :routes="child.messages_home.routes"
                           :api="child.messages_home.api"
                           :offers-awaiting="child.messages_home.offersAwaiting"
                           :buying-discussions="child.messages_home.buyingDiscussions"
                           :selling-discussions="child.messages_home.sellingDiscussions"
                           :ticket-lang="child.messages_home.ticketLang"
                           ></messages-home>
        </div>
    </div>
@endsection

<?php
$lang = Lang::get( 'message' );
$ticketLang = Lang::get( 'tickets.component' );
$routes = [
    'deny_offer' => route('public.message.offer.deny'),
    'accept_offer' => route('public.message.offer.accept'),
    'discussion' => route('public.message.discussion.page',['ticket_id','discussion_id'])
];
$api = [

];
?>

@push('vue-data')
    <script type="text/javascript">
        data.messages_home = {
            lang: {!!json_encode($lang)!!},
            ticketLang: {!! json_encode($ticketLang) !!},
            user: {!! json_encode($user) !!},
            routes: {!! json_encode($routes) !!},
            api: {!! json_encode($api) !!},
            offersAwaiting: {!! json_encode($offersAwaiting) !!},
            buyingDiscussions: {!! json_encode($buyingDiscussions) !!},
            sellingDiscussions: {!! json_encode($sellingDiscussions) !!}
        }
    </script>
@endpush
