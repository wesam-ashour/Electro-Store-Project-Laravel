<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'address' => 'required',
            'code' => 'sometimes|string|max:255',
            'notess' => 'sometimes|max:255',
            'payment' => 'required|max:255|min:1',
        
        ];
    }
}
