@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="messages-home">
            <messages-home :lang="lang"
                           :user="user"
                           :csrf="csrf"
                           :routes="routes"
                           :api="api"
                           :offers-awaiting="offersAwaiting"
                           :buying-discussions="buyingDiscussions"
                           :selling-discussions="sellingDiscussions"
                           :ticket-lang="ticketLang"
                           ></messages-home>
        </div>
    </div>
@endsection

@push('scripts')
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

    <script type="text/javascript">
        var buyTicket = new Vue({
            el: '#messages-home',
            data: {
                lang: {!!json_encode($lang)!!},
                ticketLang: {!! json_encode($ticketLang) !!},
                user: {!! json_encode($user) !!},
                csrf: '{!! csrf_token() !!}',
                routes: {!! json_encode($routes) !!},
                api: {!! json_encode($api) !!},
                offersAwaiting: {!! json_encode($offersAwaiting) !!},
                buyingDiscussions: {!! json_encode($buyingDiscussions) !!},
                sellingDiscussions: {!! json_encode($sellingDiscussions) !!}
            }
        });
    </script>
@endpush
