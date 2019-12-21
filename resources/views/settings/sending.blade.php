@extends('layouts.main')

@section('content')

<h3>Sending settings</h3>

<br>

Select sending provider: 

<br> <br>

<ul>
    <li>Amazon SES <a href="{{ route('settings.create.aws') }}" class="border px-2" >+</a> </li>
    <li>ElasticEmail</li>
    <li>MailGun</li>
    <li>SendGrid</li>
    <li>SparkPost</li>
    <li>Mailjet</li>
    <li>SMTP</li>
</ul>


@endsection