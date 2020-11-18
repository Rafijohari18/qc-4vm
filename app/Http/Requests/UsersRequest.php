<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        if($this->method() == 'PUT') {
            return [
                'name' => 'required|string|min:5|max:255',
                'username' => 'required|string|min:5|max:255|unique:users,username,'.$this->id,
                'email' => 'required|max:255|unique:users,email,'.$this->id,
                'roles' => 'required',
                'password' => 'nullable|confirmed|min:8',
            ];

        } else {
            return [
                'name' => 'required|string|min:5|max:255',
                'username' => 'required|string|min:5|max:255|unique:users,username',
                'email' => 'required|email|max:255|unique:users,email',
                'roles' => 'required',
                'password' => 'required|confirmed|min:8',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.min' => 'Name minimal 5 character',
            'username.required' => 'Username is required',
            'username.min' => 'Username minimal 5 character',
            'username.unique' => 'Username already exist',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exist',
            'roles.required' => 'Roles is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password minimal 8 character',
            'password.confirmed' => 'Password confirm must be same',
        ];
    }
}
