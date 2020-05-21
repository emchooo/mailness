@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
	<h1 class="text-gray-700 text-2xl py-4" >Create new template</h1>
</div>

 <form action="{{ route('templates.store') }}" method="POST">
	@csrf
	<input type="text" name="name" class="border bg-gray-300 mb-3 p-2" placeholder="Name" value="{{ old('name') }}" >
		<x-errorExists
		controlName="name">
		</x-errorExists>
	<br>

	<textarea name="content" id="editor" cols="30" rows="10" class="border bg-gray-300 border-1" >{{ old('content') }}</textarea>

		<x-errorExists
		controlName="content">
		</x-errorExists>

	<input type="submit" value="Save" class="bg-blue-500 block text-white px-6 py-3 mt-4">
 </form>
@endsection

@push('pageSpecificJS')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content', {
		fullPage: true,
	});
</script>
@endpush