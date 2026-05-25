<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employee::with(['department', 'manager']);

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('manager_id')) {
            $query->where('manager_id', $request->manager_id);
        }

        if ($request->filled('joining_from')) {
            $query->whereDate('joining_date', '>=', $request->joining_from);
        }

        if ($request->filled('joining_to')) {
            $query->whereDate('joining_date', '<=', $request->joining_to);
        }

        $employees = $query->orderBy('full_name')->paginate(10)->withQueryString();
        $departments = Department::orderBy('name')->get();
        $managers = Manager::orderBy('name')->get();

        return view('employees.index', compact('employees', 'departments', 'managers'));
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        Employee::create($request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Request $request, Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()
            ->route('employees.index', $request->only(['search', 'department_id', 'manager_id', 'joining_from', 'joining_to', 'page']))
            ->with('success', 'Employee deleted successfully.');
    }
}
