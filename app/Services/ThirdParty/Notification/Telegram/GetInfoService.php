<?php

namespace App\Services\ThirdParty\Notification\Telegram;

use App\DTO\UserDTO;
use App\Models\User;

class GetInfoService
{
    /**
     * @throws \Exception
     */
    public function subscription(array $telegramMessage): void
    {
        $userData = $telegramMessage['message']['from'] ?? null;

        if (!$userData) throw new \Exception('No user data');

        $telegramId = $userData['id'];
        $firstName = $userData['first_name'];

        switch ($telegramMessage['message']['text']) {
            case '/start':
                $userDTO = new UserDTO($telegramId, $firstName);
                break;
            case '/stop':
                $userDTO = new UserDTO($telegramId, $firstName, false);
                break;
            default: throw new \Exception('Unknown command');
        }

        $user = User::updateOrCreate(
            ['telegram_id' => $userDTO->telegram_id],
            [
                'name' => $userDTO->name,
                'subscribed' => $userDTO->subscribed,
            ]
        );

        app(SendInfoService::class)
            ->send($user->telegram_id, ($user->subscribed ? 'subscribed' : 'unsubscribed'));
    }
}
