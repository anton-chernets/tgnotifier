<?php

namespace App\Services\ThirdParty\Todo;

class FilterTodoService
{
    public static function getActualTodos(array $todos): array
    {
        return array_filter($todos, fn($todo) => $todo['completed'] === false && $todo['userId'] <= 5);
    }

    public static function groupedByUserIdsTodos(array $todos): array
    {
        $result = [];
        foreach ($todos as $todo) {
            $userId = $todo['userId'];
            if (!isset($result[$userId])) {
                $result[$userId] = [];
            }
            $result[$userId][] = $todo;
        }
        return $result;
    }

    public static function getTitlesByUserId(array $groupedTodos, int $userId): array
    {
        if (!isset($groupedTodos[$userId])) {
            return [];
        }

        return array_map(fn($todo) => $todo['title'], $groupedTodos[$userId]);
    }
}
