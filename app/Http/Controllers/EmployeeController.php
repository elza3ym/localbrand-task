<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ProcessEmployeeImport;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeRepository $employeeRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return $this->employeeRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx|max:2048',
        ]);

        $path = $request->file('file')->store('imports');
        ProcessEmployeeImport::dispatch(Storage::path($path));

        return response()->json(['message' => 'Import started!'], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
        return $employee;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
