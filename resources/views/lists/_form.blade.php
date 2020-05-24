<x-forms.controls.text-box controlName='name' placeholder="List Name"></x-forms.controls.text-box>

		<x-forms.controls.text-box controlName='from_name' placeholder="From Name"></x-forms.controls.text-box>

		<x-forms.controls.text-box controlName='from_email' placeholder="From Email"></x-forms.controls.text-box>
		
		<div class="block ml-2 my-2">
            {!! Form::checkbox('double_opt_in', '1', old('double_opt_in')) !!}
			<span>Double Opt-In</span>
		</div>
