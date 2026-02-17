<?php

namespace App\Http\Requests\Transmittal;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransmittalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create transmittals'); // Or simply true if using policy checks in controller
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isDraft = $this->input('status') === 'Draft';

        $rules = [
            'reference_number' => 'required|unique:transmittals',
            'transmittal_date' => 'required|date',
            'receiver_office_id' => 'required|exists:offices,id',
            'status' => 'required|in:Draft,Submitted',
        ];

        if (!$isDraft) {
            $rules['items'] = 'required|array|min:1';
            $rules['items.*.quantity'] = 'required|numeric|min:0.5';
            $rules['items.*.description'] = 'required|string';
        } else {
            $rules['items'] = 'nullable|array';
            $rules['items.*.quantity'] = 'nullable|numeric';
            $rules['items.*.description'] = 'nullable|string';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if ($this->has('items')) {
            $items = array_values(array_filter($this->items, function ($item) {
                return !empty($item['quantity']) || !empty($item['description']) || !empty($item['remarks']);
            }));
            $this->merge(['items' => $items]);
        }
    }
}
