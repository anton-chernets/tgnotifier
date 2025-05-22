<?php

namespace App\Console\Commands;

use App\Services\ThirdParty\Todo\CachedTodoService;
use App\Jobs\NotifyUserTasksJob;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;
use Throwable;

class NotifyTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Tasks';

    /**
     * Execute the console command.
     *
     * @param UserRepository $userRepository
     * @param CachedTodoService $cachedTodoService
     * @return void
     * @throws Throwable
     */
    public function handle(
        UserRepository $userRepository,
        CachedTodoService $cachedTodoService,
    ): void {
        $cachedTodoService->setGroupedUncompletedTodos();

        $userRepository->getSubscribedUsers()->each(function ($user) use (&$jobs) {
            NotifyUserTasksJob::dispatch($user);
        });
    }
}
