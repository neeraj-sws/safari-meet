<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEnquiryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'email'             => 'required|email',
            'number'            => 'required|string|min:10|max:10',
            'safaris'           => 'required|integer|min:1',
            'travellers'        => 'required|integer|min:1',
            'accommodation_id'  => 'required',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'url'               => 'required|url',
            'type_id'           => 'required',
            'type'              => 'required',
            'source'            => 'required',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 200)
        );
    }
}
