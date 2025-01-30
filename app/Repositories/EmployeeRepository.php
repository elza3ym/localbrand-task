<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EmployeeRepository
{
    public function getAll(): LengthAwarePaginator
    {
        return Employee::paginate(15);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function delete($id): bool
    {
        $employee = Employee::findOrFail($id);
        return $employee->delete();
    }
}
