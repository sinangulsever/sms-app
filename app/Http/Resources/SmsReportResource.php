<?php

namespace App\Http\Resources;

use App\Enums\Enums;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SmsReportResource",
 *     title="SmsReportResource",
 *     description="SmsReportResource",
 *     @OA\Property(property="id", type="integer",description="Id"),
 *     @OA\Property(property="send_date", type="string",description="Send Date Time"),
 *     @OA\Property(property="status_code", type="integer",description="Status Code",enum={0,1,2}),
 *     @OA\Property(property="status_text", type="string",description="Status Text",enum={"Pending","Success","Failed"}),
 *     @OA\Property(property="pending_count", type="integer",description="Pending Count"),
 *     @OA\Property(property="success_count", type="integer",description="Success Count"),
 *     @OA\Property(property="fail_count", type="integer",description="Fail Count"),
 *     @OA\Property(property="total_count", type="integer",description="Total Count"),
 *     @OA\Property(property="created_at", type="string",description="Created At"),
 *     @OA\Property(property="sms_details", type="array", @OA\Items(ref="#/components/schemas/SmsDetailResource")),
 * )
 */
class SmsReportResource extends JsonResource
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
            'pending_count' => $this->pending_count,
            'success_count' => $this->success_count,
            'fail_count' => $this->fail_count,
            'total_count' => $this->total_count,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'sms_details' => SmsDetailResource::collection($this->sms_details),
        ];
    }
}
