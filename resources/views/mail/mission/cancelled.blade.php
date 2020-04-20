@component('mail::message')
Hello {{$name}},

{{$message}}

@component('mail::button', ['url' => $url])
View Mission Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
