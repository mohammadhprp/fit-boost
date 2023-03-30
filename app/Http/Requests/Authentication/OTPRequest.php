<?php

namespace App\Http\Requests\Authentication;


use Illuminate\Foundation\Http\FormRequest;

class OTPRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'receiver' => 'required',
            'receiver_channel' => 'required|integer|between:1,2',
        ];
    }
}
