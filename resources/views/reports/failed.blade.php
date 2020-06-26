@extends('layouts.main')

@section('content')

<h1 class="text-xl py-5" >Report - {{ $campaign->subject }}</h3>

<ul class="py-2" >
<li class="inline pr-5 text-blue-500 " ><a href="{{ route('campaigns.report', $campaign->id) }}">Preview</a></li>
    <li class="inline px-5 " ><a href="{{ route('campaigns.report.opens', $campaign->id) }}">Link for list of opens</a></li>
    <li class="inline px-5" ><a href="#">Link for list of clicks</a></li>
    <li class="inline px-5" ><a href="#">Link for list of unsubscribed users</a></li>
</ul>

<h2>List of failed sends</h2>

<div class="flex flex-col">
  <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
      <table class="min-w-full">
        <thead>
          <tr>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
              Email
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
              Failure reason
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
              Failed at
            </th>
          </tr>
        </thead>
        <tbody>

          @foreach($campaign->failed as $failed)
            <tr class="bg-white">
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                    {{ $failed->contact->email }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                    {{ $failed->failed_reason }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                    {{ $failed->failed_at }}
                </td>
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
  </div>
</div>

<form action="{{ route('campaigns.retry_failed', $campaign->id) }}" method="POST" >
    @csrf 

    <input type="submit" value="Retry" class="bg-red-500 px-6 py-2 mt-5" >

</form>

@endsection