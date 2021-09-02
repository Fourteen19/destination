<?php

namespace App\Jobs;

use App\Models\Admin\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\BatchDeleteCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserOfCompletedBatchDelete implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $institutionFrom;

    public function __construct(Admin $user, $institutionFrom)
    {
        $this->user = $user;
        $this->institutionFrom = $institutionFrom;
    }

    public function handle()
    {
        $this->user->notify(new BatchDeleteCompleted($this->user, $this->institutionFrom));
    }
}
