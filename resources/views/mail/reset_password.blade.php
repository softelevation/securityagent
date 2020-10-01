@component('mail::message')
{{__('messages.hello')}} {{$name}},

{{__('messages.reset_pwd_text1')}}


@component('mail::button', ['url' => $url])
{{__('messages.reset_password_subject')}}
@endcomponent

{{__('messages.reset_pwd_text2')}}

{{__('messages.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
