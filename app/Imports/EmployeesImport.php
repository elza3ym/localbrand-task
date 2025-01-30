<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use App\Transformers\EmployeeDataTransformer;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $transformedData = EmployeeDataTransformer::transform($row);


        try {
            return Employee::create([
                'username' => $transformedData['user_name'],
                'name_prefix' => $transformedData['name_prefix'] ?? '',
                'first_name' => $transformedData['first_name'],
                'middle_initial' => $transformedData['middle_initial'] ?? '',
                'last_name' => $transformedData['last_name'],
                'gender' => $transformedData['gender'],
                'email' => $transformedData['e_mail'],
                'date_of_birth' => $transformedData['date_of_birth'],
                'time_of_birth' => $transformedData['time_of_birth'],
                'age_in_yrs' => $transformedData['age_in_yrs'],
                'date_of_joining' => $transformedData['date_of_joining'],
                'age_company_in_yrs' => $transformedData['age_in_company_years'],
                'phone' => $transformedData['phone_no'],
                'place_name' => $transformedData['place_name'] ?? '',
                'county' => $transformedData['county'] ?? '',
                'city' => $transformedData['city'],
                'zip' => $transformedData['zip'],
                'region' => $transformedData['region'] ?? '',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error parsing row: ' . json_encode($row) . ' - ' . $e->getMessage());
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'user_name' => 'required|string|unique:employees,username',
            'name_prefix' => 'nullable|string',
            'first_name' => 'required|string',
            'middle_initial' => 'nullable|string|max:1',
            'last_name' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'e_mail' => 'required|email|unique:employees,email',
            'date_of_birth' => 'required|date',
            'time_of_birth' => 'required',
            'age_in_yrs' => 'required|numeric|min:0',
            'date_of_joining' => 'required|date',
            'age_in_company_years' => 'required|numeric|min:0',
            'phone_no' => 'required|string',
            'place_name' => 'nullable|string',
            'county' => 'nullable|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'region' => 'nullable|string',
        ];
    }



    public function chunkSize(): int
    {
        return 10;
    }

    public function headingRow(): int
    {
        return 1; // Assuming the first row is the header row
    }
}
