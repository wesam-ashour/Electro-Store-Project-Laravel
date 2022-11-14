<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProducts extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'description_en' => ['required', 'string', 'max:255'],
            'description_ar' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50','min:1'],
            'price' => ['required', 'numeric', 'min:1','max:200000'],
            'offer_price' => ['required', 'numeric', 'min:1','max:200000'],
            'cover' => ['required','mimes:jpeg,png,jpg,gif'],
            'material_id' => ['required'],
            'size_id' => ['required'],
            'category_id' => ['required'],
        ];
    }
}