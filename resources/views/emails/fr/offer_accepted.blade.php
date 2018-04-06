@component('mail::message')
# Hello  {{$user->first_name}} !

Votre offre de **{{$discussion->price}} {{$discussion->currency}}** pour le ticket ci-dessous est acceptée!

@component('mail::ticket',['ticket'=>$discussion->ticket, 'lang'=>'fr'])
@endcomponent

@component('mail::button', ['url' => route('public.message.discussion.page',[
                $discussion->ticket->id,
                $discussion->id
            ]),'color'=>'blue'])
Commencer à discuter
@endcomponent

@endcomponent
