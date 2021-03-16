<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiResponser;
use App\Models\Book;

class Upsert extends FormRequest
{
    use ApiResponser;
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        if ($this->book) {
            $rules =  [
                'name' => 'required',
                'desc' => 'required',
                'image.*' => 'mimes:jpeg,png,jpg|max:4048',
            ];
            return $rules;
        } else {
            $rules =  [
                'code' => 'required|max:3|unique:books,code,id',
                'name' => 'required',
                'desc' => 'required',
                'image.*' => 'required|mimes:jpeg,png,jpg|max:4048',
            ];
            return $rules;
        }
    }
    protected function failedValidation(Validator $validator)
    {
        $data['errors'] = $validator->errors();
        throw new HttpResponseException($this->error($data));
    }
}
