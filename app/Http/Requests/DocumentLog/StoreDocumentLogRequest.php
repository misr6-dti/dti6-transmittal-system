<?php

namespace App\Http\Requests\DocumentLog;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentLogRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create document-logs');
    }

    public function rules()
    {
        $isDraft = $this->input('status') === 'Draft';

        $rules = [
            'reference_number' => 'required|unique:document_logs',
            'log_date' => 'required|date',
            'receiver_division_id' => 'required|exists:divisions,id',
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
