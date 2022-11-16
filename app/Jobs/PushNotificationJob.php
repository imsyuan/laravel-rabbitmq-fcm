<?php

namespace App\Jobs;

use App\Http\Controllers\HomeController;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        if (true) {
            echo 'Event has been handle:'. $this->message . PHP_EOL;
            $json = json_decode($this->message, true);
            \Log::info("[Event has been handle]:".$this->message);

            // 發送訊息至 FCM
            $result = (new HomeController)->notification('Incoming message', $json['text']);
            echo 'Sent notification result:'. $result . PHP_EOL;
            \Log::info("[Sending to FCM result]:". $result);

            // 取得目前時間
            $current_time = date('Y-m-d H:i:s');
            $fcm_result = [
                'identifier' => $json['identifier'],
                'deliverAt' => $current_time
            ];

            // 將 FCM 結果寫入 DB
            Job::create([
                'fcm_job' => json_encode($fcm_result)
            ]);

            if ($result) {
                PublishResultJob::dispatch(new PublishResultJob($fcm_result))->onQueue('notification.done');
            }
        }
    }
}
