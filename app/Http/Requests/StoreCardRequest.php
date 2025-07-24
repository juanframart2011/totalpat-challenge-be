<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
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
            'name'       => 'required|string|max:255',
            'color'      => 'required|string|max:30',
            'category_id' => ['required','exists:categories,id'],
            'image'      => ['nullable','image','mimes:jpg,jpeg,png','max:1024'],   // ≤1 MB
            'attributes' => 'nullable|array',
        ];
    }
}
