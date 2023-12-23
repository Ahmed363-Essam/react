<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $errors = [];

            foreach ($validator->errors()->toArray() as $field => $messages) {
                $errors[$field] = $messages;
            }

            $response = ApiResponse::sendResponse(422, $errors, 'Validation Errors');
            throw new ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:products,title,' . $this->id,
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust mime types and max size as needed
        ];
    }
}
