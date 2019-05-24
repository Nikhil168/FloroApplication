<?php

namespace App\Jobs;

use App\Services\ProcessUserExportsJobService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Facades\Excel;

class ProcessUserExportsJob implements ShouldQueue
{
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->queue = env('EXPORT_USERS_QUEUE');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProcessUserExportsJobService $processUserExportsJobService)
    {
       // dd('sss111s');
        $processUserExportsJobService->processUserExports($this->user);
    }
}
