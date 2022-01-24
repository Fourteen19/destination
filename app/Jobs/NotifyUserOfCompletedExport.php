<?php

namespace App\Jobs;

use App\Models\Admin\Admin;
use Illuminate\Bus\Queueable;
use App\Notifications\ReportReady;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $filename;
    public $user;
    public $clientId;

    public function __construct(Admin $user, $filename, $clientId)
    {
        $this->user = $user;
        $this->filename = $filename;
        $this->clientId = $clientId;
    }

    public function handle()
    {
        $this->user->notify(new ReportReady($this->filename, $this->clientId));
    }
}
