<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventBookingRequest extends FormRequest
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
            'event_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'regex:/^\d{10,11}$/'],
            'participants' => ['required', 'integer', 'min:1', 'max:30'],
        ];
    }
}
