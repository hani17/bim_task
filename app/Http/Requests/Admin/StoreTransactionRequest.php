<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
            'payer' => [
                'required',
                'integer',
                'exists:users,id,role,' . UserRole::CUSTOMER->value
            ],
            'due_on' => 'required|date',
            'vat' => 'required|numeric|max:100',
            'is_vat_inclusive' => 'required|in:0,1',
        ];
    }
}
