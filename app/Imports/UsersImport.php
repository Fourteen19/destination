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
//
    use Importable;

    private $rows = 0;
    public $institution_id;
    public $client_id;

    function __construct($client = null, $institution = null)
    {
        $this->client_id = $client;
        $this->institution_id = $institution;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        ++$this->rows;

        return new User([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'personal_email' => $row['personal_email'],
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

        return [
            '*.email' => ['email', 'required', 'unique:users,email', 'unique:users,personal_email'],
            '*.personal_email' => ['nullable', 'email', 'unique:users,email', 'unique:users,personal_email'],
            '*.password' => ['required'],
            '*.school_year' => ['required', 'numeric'],
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
            '*.personal_email.unique' => 'The :attribute has already been taken.',
        ];
    }


    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return ['personal_email' => 'personal email',
                'school_year' => 'school year',
                'birth_date' => 'date of birth',
                ];
    }

}
