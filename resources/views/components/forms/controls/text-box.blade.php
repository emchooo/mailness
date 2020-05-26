<div class="sm:col-span-6">
    {!! Form::label($controlName, $labelText, ['class' => 'block text-sm font-medium leading-5 text-gray-700']) !!}

    <div class="mt-1 rounded-md shadow-sm">
        {!! Form::text($controlName, old($controlName), [
        'class' => (string) Str::of('border rounded p-2 block w-full sm:text-sm sm:leading-5')->appendWhen($errors->has($controlName),' border-red-500'),
        'placeholder' => $placeholder,
        'id' => $controlName,
        ]) !!}
    </div>
    <div> @error($controlName) <p class="text-red-500 text-xs italic">{{$message}}</p> @enderror </div>
</div>