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
    public $clientId;

    public function __construct(Admin $user, $nbUser, $institutionFrom, $institutionTo, $clientId)
    {
        $this->user = $user;
        $this->nbUser = $nbUser;
        $this->institutionFrom = $institutionFrom;
        $this->institutionTo = $institutionTo;
        $this->clientId = $clientId;
    }

    public function handle()
    {
        $this->user->notify(new BatchTransferCompleted($this->user, $this->nbUser, $this->institutionFrom, $this->institutionTo, $this->clientId));
    }
}
