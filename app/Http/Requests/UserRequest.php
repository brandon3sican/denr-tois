<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ? $this->route('user')->id : null;
        
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'string',
                'min:8',
                'confirmed',
            ],
            'is_admin' => ['boolean'],
            'employee_id' => [
                'required',
                'integer',
                'exists:employees,id',
                Rule::unique('users', 'employee_id')->ignore($userId),
            ],
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'employee_id.unique' => 'This employee already has a user account.',
        ];
    }
}
