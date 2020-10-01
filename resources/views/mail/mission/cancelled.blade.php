@component('mail::message')
{{__('messages.hello')}} {{$name}},

{{$message}}

@component('mail::button', ['url' => $url])
View Mission Details
@endcomponent

{{__('messages.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
