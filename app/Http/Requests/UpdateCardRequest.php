<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['sometimes','string','max:255'],
            'color'       => ['sometimes','string','max:30'],
            'category_id' => ['sometimes','exists:categories,id'],
            'attributes'  => ['sometimes','array'],
            'image'       => ['sometimes','image','mimes:jpg,jpeg,png','max:1024'],
        ];
    }
}
