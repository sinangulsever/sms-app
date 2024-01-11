<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CustomerResource",
 *     title="CustomerResource",
 *     @OA\Property(property="id", type="integer",description="Customer Id"),
 *     @OA\Property(property="identity", type="string",description="Customer Identity"),
 *     @OA\Property(property="name", type="string",description="Customer Name"),
 *     @OA\Property(property="email", type="string",description="Customer Email"),
 *     @OA\Property(property="phone", type="string",description="Customer Phone"),
 *     @OA\Property(property="tax_no", type="string",description="Customer Tax No"),
 *     @OA\Property(property="tax_office", type="string",description="Customer Tax Office"),
 *     @OA\Property(property="address", type="string",description="Customer Address"),
 *  )
 */
class CustomerResource extends JsonResource
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
            'identity' => $this->identity,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'tax_no' => $this->tax_no,
            'tax_office' => $this->tax_office,
            'address' => $this->address,
        ];
    }
}
