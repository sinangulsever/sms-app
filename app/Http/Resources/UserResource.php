<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 *     schema="UserResource",
 *     title="UserResource",
 *     @OA\Property(property="name", type="string",description="User Name"),
 *     @OA\Property(property="email", type="string",description="User Email"),
 *     @OA\Property(property="customer", type="object", ref="#/components/schemas/CustomerResource",description="User Customer"),
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'name' => $this->name,
            'email' => $this->email,
            'customer' => new CustomerResource($this->customer),
        ];
    }
}
