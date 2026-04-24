<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:100'],
            'inquiry_type' => ['required', 'in:general,booking,complaint,suggestion'],
            'priority' => ['required', 'in:low,medium,high'],
            'message' => ['required', 'string', 'min:20'],
        ];
    }
}
