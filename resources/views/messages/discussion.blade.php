@extends('layouts.dashboard')

@section('dashboard-content')
        <div  id="messages-discussion">
            <discussion :lang="child.discussion.lang"
                        :user="child.discussion.user"
                        :csrf="child.discussion.csrf"
                        :routes="child.discussion.routes"
                        :api="child.discussion.api"
                        :ticket-lang="child.discussion.ticketLang"
                        :discussion-default="child.discussion.discussion"
            ></discussion>
        </div>
@endsection

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

@push('vue-data')
    <script type="application/javascript">
        data.discussion = {
            lang: {!!json_encode($lang)!!},
            ticketLang: {!! json_encode($ticketLang) !!},
            user: {!! json_encode($user) !!},
            csrf: '{!! csrf_token() !!}',
            routes: {!! json_encode($routes) !!},
            api: {!! json_encode($api) !!},
            discussion: {!! json_encode($discussion) !!}
        };
    </script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $crisp.push(["do", "chat:hide"]);
    </script>
@endpush
