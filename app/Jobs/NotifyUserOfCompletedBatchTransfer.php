<?php

namespace App\Jobs;

use App\Models\Admin\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\BatchTransferCompleted;

class NotifyUserOfCompletedBatchTransfer implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(Admin $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->notify(new BatchTransferCompleted($this->user));
    }
}
