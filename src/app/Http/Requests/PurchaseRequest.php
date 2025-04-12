<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => 'お支払い方法を選択してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!session()->has('address')) {
                $validator->errors()->add('address_id', '配送先を選択してください。');
            }
        });
    }
}
