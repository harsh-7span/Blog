<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiResponser;

class Upsert extends FormRequest
{
    use ApiResponser;
 
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'dateOfbirth' => 'required|date|date_format:Y-m-d',
            'bio' => 'required|max:250',
            'profile' => 'required'
        ];
        return $rules;

    }
    protected function failedValidation(Validator $validator)
    {
        $data['errors'] = $validator->errors();
        throw new HttpResponseException($this->error($data));
    }
}
