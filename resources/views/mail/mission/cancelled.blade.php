@component('mail::message')
{{__('messages.hello')}} {{$name}},

{{$message}}

@component('mail::button', ['url' => $url])
{{__('messages.view_mission_details')}}
@endcomponent

{{__('messages.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
