<?php

namespace App\Exports;

use App\Models\User;
use App\Models\SystemTag;
use App\Models\Admin\Admin;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersNotLoggedInExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;

    public function __construct(int $clientId, int $institutionId)
    {
        $this->clientId = $clientId;
        $this->institutionId = $institutionId;

        $this->adviserNames = app('reportingService')->getInstitutionAdvisers($institutionId);

    }



    /**
     * @return array
     */
    public function headings(): array
    {

        return [
            'First Name',
            'Last Name',
            'Date of Birth',
            'School Year',
            'Postcode',
            'School/Client Email Address (Primary)',
            'Personal Email Address',
            'Adviser(s)',
        ];

    }


    /**
    * @var User $user
    */
    public function map($user): array
    {

        return [
            $user->first_name,
            $user->last_name,
            $user->birth_date,
            $user->school_year,
            $user->postcode,
            $user->email,
            $user->personal_email,
            $this->adviserNames,
        ];
    }



    public function query()
    {
        return User::query()->select('first_name', 'last_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email')
                            ->where('institution_id', $this->institutionId)
                            ->where('nb_logins', 0);

    }
}
