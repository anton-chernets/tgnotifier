<?php

namespace App\Services\ThirdParty\Todo;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class CachedTodoService
{
    public function __construct(
        protected TodoAPIInterface $todosAPIService
    ) {}

    public function setGroupedUncompletedTodos(): void
    {
        Cache::remember('todos.uncompleted', now()->addMinutes(10), function () {
            return $this->getTodos();
        });
    }

    /**
     * @throws GuzzleException
     */
    public function getGroupedUncompletedTodos(): array
    {
        return Cache::get('todos.uncompleted', $this->getTodos());
    }

    /**
     * @throws GuzzleException
     */
    private function getTodos(): array
    {
        $todos = $this->todosAPIService->getTodos();
        $filtered = FilterTodoService::getActualTodos($todos);
        return FilterTodoService::groupedByUserIdsTodos($filtered);
    }
}
