@component('mail::message')
# Hello  {{$user->first_name}} !

Your offer of **{{$discussion->price}} {{$discussion->currency}}** for the ticket below was accepted!

@component('mail::ticket',['ticket'=>$discussion->ticket, 'lang'=>'en'])
@endcomponent

@component('mail::button', ['url' => route('public.message.discussion.page',[
                $discussion->ticket->id,
                $discussion->id
            ]),'color'=>'blue'])
Start discussing now
@endcomponent

@endcomponent
