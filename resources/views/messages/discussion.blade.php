@extends('layouts.dashboard')

@section('dashboard-content')
        <div  id="messages-discussion">
            <discussion :lang="lang"
                        :user="user"
                        :csrf="csrf"
                        :routes="routes"
                        :api="api"
                        :ticket-lang="ticketLang"
                        :discussion-default="discussion"
            ></discussion>
        </div>
@endsection

@push('scripts')
    <?php
    $lang = Lang::get( 'message' );
    $ticketLang = Lang::get( 'tickets.component' );
    $routes = [
        'sell' => route('public.message.discussion.sell',[$discussion->ticket->id,$discussion->id]),
        'profile' => route('public.profile.stanger',['user_id'])
    ];
    $api = [
        'send' => route('api.discussion.send',['ticket_id','discussion_id']),
        'refresh' => route('api.discussion.refresh',['ticket_id','discussion_id'])
    ];
    ?>

    <script type="text/javascript">
        $crisp.push(["do", "chat:hide"]);

        var buyTicket = new Vue({
            el: '#messages-discussion',
            data: {
                lang: {!!json_encode($lang)!!},
                ticketLang: {!! json_encode($ticketLang) !!},
                user: {!! json_encode($user) !!},
                csrf: '{!! csrf_token() !!}',
                routes: {!! json_encode($routes) !!},
                api: {!! json_encode($api) !!},
                discussion: {!! json_encode($discussion) !!}
            }
        });
    </script>
@endpush
