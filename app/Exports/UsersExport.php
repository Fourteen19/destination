<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Admin\Admin;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;

    public function __construct(int $clientId, int $institutionId)
    {
        $this->clientId = $clientId = 1;
        $this->institutionId = $institutionId;

        $advisers = Admin::adminTypeFromInstitution(config('global.admin_user_type.Advisor'), 1)->select('admins.first_name', 'admins.last_name')->get();
        $this->adviserNames = "";
        foreach($advisers as $adviser)
        {
            $this->adviserNames .= $adviser->first_name." ".$adviser->last_name;
        }



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
            'RONI',
            'RODI',
            'NEET 16-18',
            'NEET 18+',
            'Below Level 2',
            'Adviser(s)',
            'Times Logged in',
            'No of articles read',
            'No of red flag articles read',
            'CV Builder completed',
            'CRS Score',
        ];

//Route A - N (column for each)
//Sector A - N (column for each)
//Subject A - N (column for each)


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
            ($user->roni == 0) ? '0' : $user->roni,
            ($user->rodi == 0) ? '0' : $user->rodi,
            ($user->tags->contains('name', "NEET 18+")) ? "Y" : "N",
            ($user->tags->contains('name', "NEET 16-18")) ? "Y" : "N",
            ($user->tags->contains('name', "Below Level 2")) ? "Y" : "N",
            $this->adviserNames,
            $user->nb_logins,
        ];
    }

    public function query()
    {
        return User::query()->select('id', 'first_name', 'last_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email', 'roni', 'rodi', 'nb_logins');

    }
}
