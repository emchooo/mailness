<h1>Please confirm</h1>

<a href="{{ route('subscribe.confirm', [ $contact->list->uuid, $contact->uuid ] ) }}">Confirm your subscription to {{ $contact->list->name }}</a>