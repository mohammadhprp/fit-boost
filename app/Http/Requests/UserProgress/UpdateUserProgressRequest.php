<?php

namespace App\Http\Requests\UserProgress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'weight' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'height' => 'nullable|integer',
            'body_fat' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'notes' => 'nullable'
        ];
    }
}
