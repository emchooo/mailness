<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject'   => ['required'],
            'sending_name'  => ['required'],
            'sending_email' => ['required', 'email'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'subject.required' => 'The :attribute is required',
            'sending_name.required' => 'The :attribute is required',
            'sending_email.required' => 'The :attribute is required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'subject' => 'Subject',
            'sending_name' => 'Sending Name',
            'sending_email' => 'Sending Email',
            'html' => 'HTML',
        ];
    }
}
