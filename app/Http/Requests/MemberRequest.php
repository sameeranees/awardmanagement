<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
        $rules = [];
        /*switch ( strtoupper(request()->_method) ) {

            case 'PUT':
                $rules = [
                    'first_name' => 'required|string',
                    'surname' => 'required|string|unique:members,surname',
                    'fathers_name' => 'required|string',
                    'gender' => 'required|string',
                    'dam_no' => 'required|numeric',
                    'address' => 'required|string',
                    'name_of_institute' => 'required|string',
                    'marks_obtained' => 'nullable|numeric',
                    'total_marks' => 'nullable|numeric',
                    'gpa' => 'nullable|numeric',
                    'distinctions' => 'nullable',
                    'previous_qualifications' => 'nullable',
                    'passing_year' => 'required|numeric',
                    'A*s' => 'nullable|numeric',
                    'As' => 'nullable|numeric',
                    'Bs' => 'nullable|numeric',
                    'Cs' => 'nullable|numeric',
                    'Ds' => 'nullable|numeric',
                    'Fs' => 'nullable|numeric',
                    'degree_id' => 'required|numeric',
                    'majors_id' => 'required|numeric',
                    'status' => 'required',
                    'email' => 'required|string|email|max:191',
                    'phone' => 'required',
                ];
                break;

            default:
                $rules = [
                    'first_name' => 'required|string',
                    'surname' => 'required|string|unique:members,surname',
                    'fathers_name' => 'required|string',
                    'gender' => 'required|string',
                    'dam_no' => 'required|numeric',
                    'address' => 'required|string',
                    'name_of_institute' => 'required|string',
                    'marks_obtained' => 'nullable|numeric',
                    'total_marks' => 'nullable|numeric',
                    'gpa' => 'nullable|numeric',
                    'distinctions' => 'nullable',
                    'previous_qualifications' => 'nullable',
                    'passing_year' => 'required|numeric',
                    'A*s' => 'nullable|numeric',
                    'As' => 'nullable|numeric',
                    'Bs' => 'nullable|numeric',
                    'Cs' => 'nullable|numeric',
                    'Ds' => 'nullable|numeric',
                    'Fs' => 'nullable|numeric',
                    'degree_id' => 'required|numeric',
                    'majors_id' => 'required|numeric',
                    'status' => 'required',
                    'email' => 'required|string|email|max:191',
                    'phone' => 'required',
                ];
                break;

        }*/
        return $rules;
    }
}
