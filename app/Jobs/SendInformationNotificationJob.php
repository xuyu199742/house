<?php

namespace App\Jobs;

use App\Models\Information;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInformationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $information_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($information_id)
    {
        $this->information_id = $information_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $information = Information::find($this->information_id);

        if (!$information) {
            \Log::error('information not exist:' . $this->information_id);
            return;
        }

        $house          = $information->house;
        $subscribers    = $house->subscribers;

        foreach ($subscribers as $subscriber) {
            Message::create([
                'user_id' => $subscriber->id,
                'title' => $information->message_title ?: $information->title,
                'content' => $information->message_content ?: $information->content,
                'avatar' => $information->avatar,
                'author' => $information->author,
                'link_data' => '/pages/house/show/index?id='.$house->id
            ]);
        }
    }
}
