@component('mail::message')
# Hello  {{$user->first_name}} !

Someone sent you a new message regarding one of your tickets!

@component('mail::button', ['url' =>route('public.message.discussion.page',[$discussion->ticket_id,$discussion->id]),'color'=>'blue'])
Check out message
@endcomponent

@endcomponent
