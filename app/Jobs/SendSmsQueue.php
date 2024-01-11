<?php

namespace App\Jobs;

use App\Models\SmsDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public SmsDetail $smsDetails;

    /**
     * Create a new job instance.
     */
    public function __construct($smsDetails)
    {
        $this->smsDetails = $smsDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $number = $this->smsDetails->number;
        $message = $this->smsDetails->message;

        // bu kısım sms gönderme işlemini yapacak kısım
//        $response = Http::get('https://api.sms.ir/users/v1/Token/GetToken', [
//            'UserApiKey' => 'your api key',
//            'SecretKey' => 'your secret key'
//        ]);

        $response = [
            "IsSuccessful" => true
        ];
        $this->smsDetails->update([
            'status' => '1',
            'send_date' => now()->format('Y-m-d H:i:s'),
            'response_send' => json_encode($response)
        ]);

    }
}
