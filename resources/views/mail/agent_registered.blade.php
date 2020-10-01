@component('mail::message')
{{__('messages.hello')}} {{$name}},

{!!$message!!}

{{__('messages.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
