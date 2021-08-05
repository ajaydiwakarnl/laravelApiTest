<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
class RegisterRequest extends FormRequest
{
    use ApiResponse;

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
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required|min:4|max:10'
        ];

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error($validator->errors()->first(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
