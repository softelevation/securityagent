@component('mail::message')
Hello {{$name}},

{{$message}}

@component('mail::button', ['url' => $url])
View Payment Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
