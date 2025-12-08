<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChallengeRequest extends FormRequest
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
            'days_duration' => 'nullable|integer|min:1|max:365',
            'frequency_type' => 'required|string|in:daily,weekly,monthly,yearly',
            'frequency_count' => 'required|integer|min:1|max:7',
            'weekly_days' => 'nullable|array',
            'weekly_days.*' => 'integer|min:1|max:7',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Challenge name is required.',
            'days_duration.required' => 'Challenge duration is required.',
            'days_duration.min' => 'Challenge must be at least 1 day long.',
            'days_duration.max' => 'Challenge cannot be longer than 365 days.',
        ];
    }
}
