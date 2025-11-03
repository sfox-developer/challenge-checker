<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChallengeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'days_duration' => 'required|integer|min:1|max:365',
            'goals' => 'required|array|min:1|max:10',
            'goals.*.name' => 'required|string|max:255',
            'goals.*.description' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'goals.required' => 'At least one goal is required.',
            'goals.min' => 'At least one goal is required.',
            'goals.max' => 'You can have a maximum of 10 goals per challenge.',
            'goals.*.name.required' => 'Each goal must have a name.',
        ];
    }
}
