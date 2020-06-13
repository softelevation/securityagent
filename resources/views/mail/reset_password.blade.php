@component('mail::message')
Hello {{$name}},

{{__('messages.reset_pwd_text1')}}


@component('mail::button', ['url' => $url])
{{__('messages.reset_password_subject')}}
@endcomponent

{{__('messages.reset_pwd_text2')}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
