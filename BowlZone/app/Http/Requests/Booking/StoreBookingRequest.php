<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'lane' => ['required', 'integer', 'min:1', 'max:10'],
            'players' => ['required', 'integer', 'min:1', 'max:6'],
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
            'booking_date.required' => 'Please enter a booking date.',
            'booking_time.required' => 'Please select a booking time.',
            'lane.required' => 'Please choose a lane.',
            'players.required' => 'Please choose the number of players.',
        ];
    }
}

