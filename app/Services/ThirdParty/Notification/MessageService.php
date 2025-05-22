<?php

namespace App\Services\ThirdParty\Notification;

use App\Models\User;
use App\Services\ThirdParty\Todo\CachedTodoService;
use App\Services\ThirdParty\Todo\FilterTodoService;
use GuzzleHttp\Exception\GuzzleException;

class MessageService
{
    private CachedTodoService $cachedTodoService;
    private FilterTodoService $filterTodoService;

    public function __construct(
        CachedTodoService $cachedTodoService,
        FilterTodoService $filterTodoService
    ) {
        $this->cachedTodoService= $cachedTodoService;
        $this->filterTodoService = $filterTodoService;
    }

    /**
     * @throws GuzzleException
     */
    public function getMessageForUser(User $user): string
    {
        $todos = $this->cachedTodoService->getGroupedUncompletedTodos();
        $titles = $this->filterTodoService->getTitlesByUserId($todos, $user->id);
        return implode(', ', $titles);
    }
}
