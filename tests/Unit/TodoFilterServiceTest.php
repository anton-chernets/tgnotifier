<?php

namespace Tests\Unit;

use App\Services\ThirdParty\Todo\FilterTodoService;
use PHPUnit\Framework\TestCase;

class TodoFilterServiceTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function test_only_filtered_items_are_selected()
    {
        $json = file_get_contents(__DIR__ . '/../mocks/todos.json');
        $todos = json_decode($json, true);

        $service = new FilterTodoService();
        //TODO Reflection if protected/private method example
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('getActualTodos');

        $filteredTodos = $method->invoke($service, $todos);

        foreach ($filteredTodos as $item) {
            $this->assertFalse($item['completed']);
            $this->assertTrue($item['userId'] <= 5);
        }

        $this->assertGreaterThan(0, count($todos));
    }
}
