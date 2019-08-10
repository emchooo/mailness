<div class="border border-l-0 border-t-0 border-r-0 mb-5 pb-2" >
	<a href="{{ route('lists.show', $list->id) }}" class="mr-6 @if(request()->route()->getName() == 'lists.show') border-b-4 pb-2 pr-2  @endif" >Contacts</a>
	<a href="{{ route('fields.index', $list->id) }}" class="pr-6 @if(request()->route()->getName() == 'fields.index') border-b-4 pb-2 pr-2  @endif " >Fields</a>
	<a href="{{ route('lists.edit', $list->id) }}" class="@if(request()->route()->getName() == 'lists.edit') border-b-4 pb-2 pr-2  @endif" >Settings</a>
</div>