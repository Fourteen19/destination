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

    public function __construct(Admin $user, $filename)
    {
        $this->user = $user;
        $this->filename = $filename;
    }

    public function handle()
    {
        $this->user->notify(new ReportReady($this->filename));
    }
}
