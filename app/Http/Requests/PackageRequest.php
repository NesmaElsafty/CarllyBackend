<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:packages,title,' . $this->package,
            'period' => 'required|integer|min:1',
            'period_type' => 'required|in:Months,Years',
            'provider' => 'required|in:Car Provider,Spare Part Provider,workshop,Workshop Provider',
            'price' => 'required|integer|min:0',
            'limits' => 'required|integer|min:0',
            'feature_ids' => 'required',
            'feature_ids.*' => 'exists:features,id',
        ];
    }
}
