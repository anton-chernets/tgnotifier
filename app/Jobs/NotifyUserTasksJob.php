<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\ThirdParty\Notification\MessageService;
use App\Services\ThirdParty\Notification\Telegram\SendInfoService as TelegramNotificationService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;
    public string $message;

    /**
     * Create a new job instance.
     * @throws GuzzleException
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->message = app(MessageService::class)->getMessageForUser($user);
    }

    /**
     * Execute the job.
     */
    public function handle(
        TelegramNotificationService $telegramNotificationService
    ): void {
        logger()->info("Prepared message: ({$this->message}) to user {$this->user->id}");

        if (!empty($this->message)) {
            $telegramNotificationService->send($this->user->telegram_id, $this->message);

            logger()->info("Message: ({$this->message}) sent to user {$this->user->id}");
        } else {
            logger()->info("Message: ({$this->message}) not sent to user {$this->user->id}");
        }
    }
}
