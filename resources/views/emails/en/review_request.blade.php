@component('mail::message')

# Hello  {{$user->first_name}} !

At PasseTonBillet, we want to offer the best experience possible for a customers, and cut down
on scams and fraudulent activity. Its sometimes can be hard to this without firsthand experience.
This is why we are asking for your help to make it possible.
We're really pleased you recently sold a ticket, and we would love to know more about your experience using PasseTonBillet.
Please click on the link below to take 5 minutes to fill out our feedback form and provide any suggestions or areas which you think could be improved.

@component('mail::button', ['url' => route('home') . '#review', 'color'=>'blue'])
    Review PasseTonBillet
@endcomponent


@endcomponent