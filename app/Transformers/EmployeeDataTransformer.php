<?php

namespace App\Transformers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class EmployeeDataTransformer
{
    public static function transform(array $row)
    {
        $data = [];
        $joiningDate = Carbon::parse($row['date_of_joining']);
        $currentDate = Carbon::now();

        // if not number calculate it.
        if (empty($row['age_in_company_years']) || !is_numeric($row['age_in_company_years'])) {
            $ageInCompanyYears = $joiningDate->diffInYears($currentDate);
            $row['age_in_company_years'] = $ageInCompanyYears;
        }

        $data['time_of_birth'] = self::sanitizeTime($row['time_of_birth']);

        $data['date_of_birth'] = self::parseDate($row['date_of_birth']);
        $data['date_of_joining'] = self::parseDate($row['date_of_joining']);

        $data['e_mail'] = self::sanitizeEmail($row['e_mail']);

        $data['gender'] = self::sanitizeGender($row['gender']);

        $data['age_in_yrs'] = (float)$row['age_in_yrs'];

        $data['user_name'] = Str::lower($row['user_name']);
        $data['name_prefix'] = $row['name_prefix'];
        $data['first_name'] = $row['first_name'];
        $data['middle_initial'] = $row['middle_initial'];
        $data['last_name'] = $row['last_name'];
        $data['place_name'] = $row['place_name'] ?? '';
        $data['county'] = $row['county'] ?? '';
        $data['city'] = $row['city'];
        $data['zip'] = $row['zip'];
        $data['region'] = $row['region'] ?? '';
        $data['age_in_company_years'] = $row['age_in_company_years'] ?? '';
        $data['phone_no'] = $row['phone_no'] ?? '';

        return $data;
    }

    private static function sanitizeTime($time)
    {
        $sanitizedDate = preg_replace('/[^0-9: ]/', '', $time);
        return rtrim(trim($sanitizedDate), ':');
    }

    private static function parseDate($date)
    {
        $sanitizedDate = preg_replace('/[^0-9\/-]/', '', $date);
        $sanitizedDate = trim($sanitizedDate);
        try {
            return Carbon::createFromFormat('m/d/Y', $sanitizedDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private static function sanitizeEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    private static function sanitizeGender($gender)
    {
        if ($gender == 'M') {
            return 'Male';
        } elseif ($gender == 'F') {
            return 'Female';
        }

        return 'Other';
    }
}
