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
    public $nbUser;
    public $institutionFrom;
    public $institutionTo;

    public function __construct(Admin $user, $nbUser, $institutionFrom, $institutionTo)
    {
        $this->user = $user;
        $this->nbUser = $nbUser;
        $this->institutionFrom = $institutionFrom;
        $this->institutionTo = $institutionTo;
    }

    public function handle()
    {
        $this->user->notify(new BatchTransferCompleted($this->user, $this->nbUser, $this->institutionFrom, $this->institutionTo));
    }
}
