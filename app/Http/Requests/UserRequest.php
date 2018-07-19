<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch ( strtoupper(request()->_method) ) {

            case 'PUT':
                $rules = [
                    'name' => 'required|string',
                    'email' => 'required|string|email|max:191|unique:users,email,'. request()->_id . ',id',
                    'phone' => 'required',
                ];
                break;

            default:
                $rules = [
                    'name' => 'required|string',
                    'email' => 'required|string|email|max:191|unique:users',
                    'phone' => 'required',
                    'password' => 'required|string|min:6|confirmed'
                ];
                break;

        }
        return $rules;
    }
}
