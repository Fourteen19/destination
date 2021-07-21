<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersExport implements FromQuery, ShouldQueue
{

    use Exportable;

    public function query()
    {
        return User::query();
    }
}
