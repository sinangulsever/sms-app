<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 *     schema="LoginResource",
 *     title="LoginResource",
 *     @OA\Property(property="token", type="string",description="Token"),
 *     @OA\Property(property="expires_in", type="integer",description="Token Expires In"),
 *     @OA\Property(property="token_type", type="string",description="Token Type"),
 *)
 */
class LoginResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token,
            'expires_in' => config('jwt.ttl'),    // 2 hours env('JWT_TTL') den bu değeri değiştirebilirsiniz.
            'token_type' => 'bearer',
        ];
    }
}
