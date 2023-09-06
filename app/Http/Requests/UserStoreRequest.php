<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            "name" => "required|string|max:50",
            "father_name" => 'required|max:50',
            "email" => "required|max:191|unique:users,email",
            "password" => "required|min:8",
            "address" => "required|max:191",

        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'name.required' => 'Name is required!',
            'email.unique' => 'Email Already Taken',
            'password.required' => 'Password is required!',
            'password.min' => 'Password should minimum 8 character!',
            'address.required' => 'address is required!',
        ];
    }
}
