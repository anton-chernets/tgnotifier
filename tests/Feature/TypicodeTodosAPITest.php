<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TypicodeTodosAPITest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_todos_returns_a_successful_response(): void
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/todos');

        $this->assertTrue($response->successful());
        $this->assertIsArray($response->json());
    }
}
