<?php

namespace App\Http\Resources;

use App\Enums\Enums;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SmsDetailResource",
 *     title="SmsDetailResource",
 *     description="SmsDetailResource",
 *     @OA\Property(property="number", type="string",description="Number"),
 *     @OA\Property(property="message", type="string",description="Message"),
 *     @OA\Property(property="status_code", type="integer",description="Status Code",enum={0,1,2}),
 *     @OA\Property(property="status_text", type="string",description="Status Text",enum={"Pending","Success","Failed"}),
 *     @OA\Property(property="send_date", type="string",description="Send Date Time"),
 *     @OA\Property(property="response_send", type="string",description="Response Send"),
 *   )
 */
class SmsDetailResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number' => $this->number,
            'message' => $this->message,
            'status_code' => $this->status,
            'status_text' => Enums::smsDetailStatus($this->status),
            'send_date' => $this->send_date,
            'response_send' => $this->response_send,
        ];
    }
}
