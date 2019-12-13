@component('mail::layout')
{{-- Body --}}
{{ $slot }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
@component('mail::button', ['url' => route('help.page'),'color'=>'white'])
Help ?
@endcomponent
@endcomponent
@endslot

@endcomponent
