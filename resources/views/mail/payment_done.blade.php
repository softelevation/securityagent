@component('mail::message')
{{__('messages.hello')}} {{$name}},

{{$message}}

@component('mail::button', ['url' => $url])
View Payment Details
@endcomponent

{{__('messages.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
