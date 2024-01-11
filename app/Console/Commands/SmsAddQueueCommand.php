<?php

namespace App\Console\Commands;

use App\Jobs\SendSmsQueue;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SmsAddQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->addMinutes(3)->format('Y-m-d H:i:s');

        $sms = Sms::with(['sms_details' => function ($query) {
            $query->where('status', '0');
        }])
            ->where('status', '0')
            ->where('send_date', '<=', $date)->limit(200)->get();


        foreach ($sms as $item) {
            $delay = $item->send_date->diffInSeconds(Carbon::now());

            $smsDetail = $item->sms_details;
            foreach ($smsDetail as $itemSmsDetail) {
                SendSmsQueue::dispatch($itemSmsDetail)->delay($delay);
            }

            $item->update(['status' => '1']);

        }

    }
}
