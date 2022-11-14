<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storecoupons extends FormRequest
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
            'title' => 'required|max:150|min:5',
            'code' => 'required|max:50|min:5',
            'value' => 'required|numeric|max:100|min:1',
            'type' => 'required|max:150|min:2',
            'min_order_amt' => 'required|numeric|max:10000|min:1',
            'status' => 'required|max:50|min:1',

        ];
    }
}
