<?php

namespace App\Http\Controllers;

use App\Jobs\PushNotificationJob;
use App\Jobs\PublishResultJob;

class ProducerController extends Controller
{
    public function create()
    {
        $message = '{"identifier": "fcm-msg-a1beff5ac", "type": "device", "deviceId": "string", "text": "Notification message"}';
        $queueJobId = $this->dispatch(new PushNotificationJob($message));
        \Log::info("[Adding to RabbitMQ] - JobID: " . $queueJobId . ' - Message: ' . $message);
        if ($queueJobId) {
            PublishResultJob::dispatch()->onQueue('notification.done');
        }
        echo 'send';
    }
}
