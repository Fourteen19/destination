<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    use Importable;

    private $rows = 0;
    public $institution_id;
    public $client_id;

    function __construct($client = null, $institution = null)
    {
        $this->client_id = $client;
        $this->institution_id = $institution;

        ini_set('max_execution_time', '0');

    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        ++$this->rows;

        if (strtolower($row['school_year']) == 'post')
        {
            $row['school_year'] = 14;
        }

        return new User([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            //'personal_email' => $row['personal_email'],
            'password' => Hash::make($row['password']),
            'school_year' => $row['school_year'],
            'birth_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['birth_date'])))->format('d/m/Y'),
            'postcode' => $row['postcode'],
            'client_id' => $this->client_id,
            'institution_id' => $this->institution_id,

        ]);
    }


    public function rules(): array
    {
        //'unique:users,email,NULL,id,deleted_at,NULL'  Unique validation: check no other user has this email address and is not deleted
        return [//'email',
            '*.email' => ['required', 'unique:users,email,NULL,id,deleted_at,NULL', 'unique:users,personal_email,NULL,id,deleted_at,NULL'],
            //'*.email' => ['email', 'required', 'unique:users,email,NULL,id,deleted_at,NULL'],
            //'*.personal_email' => ['nullable', 'email', 'unique:users,email,NULL,id,deleted_at,NULL', 'unique:users,personal_email,NULL,id,deleted_at,NULL'],
            '*.password' => ['required'],
            '*.school_year' => ['required', 'in:7,8,9,10,11,12,13,POST'],
        ];
    }


    public function getRowCount(): int
    {
        return $this->rows;
    }


    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }


    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            //'*.personal_email.unique' => 'The :attribute has already been taken.',
        ];
    }


    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [//'personal_email' => 'personal email',
                'school_year' => 'school year',
                'birth_date' => 'date of birth',
                ];
    }

}
