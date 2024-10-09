<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreRolesRequest extends FormRequest
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
        return [
            'name' => ['unique:roles'],
        ];
    }

    public function messages(){
        return [
            'name.unique' => 'El :attribute esta siendo usado.'
        ];
    }
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            "isRequest"=> true,
            "isSuccess" => false,
            "isMessageError" => true,
            "message" => $validator->errors(),
            "messageError" => $validator->errors(),
            "data" => [],
            "statusCode" => 422
        ], 422));
    }
}