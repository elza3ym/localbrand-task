<?php

namespace App\Repositories\Interfaces;

use App\Models\Employee;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface
{

    /**
     * Get all employees from the DB.
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Create new employee instance.
     * @param array $data
     * @return Employee
     */
    public function create(array $data): Employee;

    /**
     * Delete employee from DB.
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
