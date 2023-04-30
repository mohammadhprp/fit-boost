<?php

namespace App\Http\Requests\Notification\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserNotificationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'nullable',
            'notify_at' => 'required'
        ];
    }
}
