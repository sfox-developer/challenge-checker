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
            'goal_library_ids' => 'nullable|array|max:10',
            'goal_library_ids.*' => 'exists:goals_library,id',
            'new_goals' => 'nullable|array|max:10',
            'new_goals.*.name' => 'required_with:new_goals|string|max:255',
            'new_goals.*.description' => 'nullable|string|max:500',
            'new_goals.*.icon' => 'nullable|string|max:10',
            'new_goals.*.category' => 'nullable|string|max:255',
        ];
    }

    /**
     * Validate that at least one goal is provided.
     */
    protected function prepareForValidation()
    {
        // Add custom validation to ensure at least one goal type is provided
        $this->merge([
            '_has_goals' => !empty($this->goal_library_ids) || !empty($this->new_goals),
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->goal_library_ids) && empty($this->new_goals)) {
                $validator->errors()->add('goals', 'Please select at least one goal from your library or add a new goal.');
            }
        });
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'goal_library_ids.max' => 'You can select a maximum of 10 goals from your library.',
            'new_goals.max' => 'You can add a maximum of 10 new goals.',
            'new_goals.*.name.required_with' => 'Each new goal must have a name.',
            'goal_library_ids.*.exists' => 'One or more selected goals do not exist in your library.',
        ];
    }
}
