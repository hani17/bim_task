<?php

namespace App\Http\Resources\Admin;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transaction */
class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'amount_with_vat' => $this->amount_with_vat,
            'due_on' => $this->due_on,
            'vat_amount' => $this->vat_amount,
            'is_vat_inclusive' => $this->is_vat_inclusive,
            'status' => $this->status,
            'status_text' => $this->status ? TransactionStatus::from($this->status)->text() : null,
            'total_paid_amount' => $this->total_paid_amount,
            'payer' => new UserResource($this->whenLoaded('payer')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments'))
        ];
    }
}
