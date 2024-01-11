<?php

namespace App\Http\Resources;

use App\Enums\Enums;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(schema="SmsResource",title="SmsResource", description="SmsResource",  required={"id","send_date","status_text","status_code","created_at","sms_details"},
 *     @OA\Property(property="id", type="integer",description="Id"),
 *     @OA\Property(property="send_date", type="string",description="Send Date"),
 *     @OA\Property(property="status_text", type="string",description="Status Text", enum={"Pending","Completed","Canceled"}),
 *     @OA\Property(property="status_code", type="integer",description="Status Code"),
 *     @OA\Property(property="created_at", type="string",description="Created At"),
 *     @OA\Property(property="sms_details", type="array",description="Sms Details", @OA\Items(ref="#/components/schemas/SmsDetailResource")),
 * )
 */
class SmsResource extends JsonResource
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
            'send_date' => $this->send_date->format('d-m-Y H:i'),
            'status_text' => Enums::smsStatus($this->status),
            'status_code' => $this->status ?? 0,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'sms_details' => SmsDetailResource::collection($this->sms_details),
        ];
    }
}
