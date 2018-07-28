<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DegreeRequest extends FormRequest
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
                    'degree_name' => 'required|string',
                ];
                break;

            default:
                $rules = [
                    'degree_name' => 'required|string',
                ];
                break;

        }
        return $rules;
    }
}
