@extends('layouts.main')

@section('content')

<h3>Sending settings</h3>

@if($service)

    <p>Provider: {{ $service->service }}</p>
    <p>Host: {{ $service->credentials['host'] }}</p>
    <p><a href="">Delete</a></p>
    <p><a href="">Edit</a></p>


@else

Please select sending provider:

<br> <br>

<ul>
    <li>Amazon SES <a href="{{ route('settings.create.aws') }}" class="border px-2" >+</a> </li>
    <li>SMTP <a href="{{ route('settings.smtp') }}" class="border px-2" >+</a> </li>
    <li>ElasticEmail</li>
    <li>MailGun</li>
    <li>SendGrid</li>
    <li>SparkPost</li>
    <li>Mailjet</li>
</ul>
@endif


@endsection