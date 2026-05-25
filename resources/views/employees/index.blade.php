@extends('layouts.app')

@section('title', 'Employees List')

@section('content')
<div class="page-card">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2 mb-4">
        <h4 class="mb-0 fw-semibold">Employees List</h4>
        <button type="button" class="btn btn-primary flex-shrink-0" data-bs-toggle="modal" data-bs-target="#employeeModal" id="addEmployeeBtn">
            <i class="bi bi-plus-lg"></i> Add Employee
        </button>
    </div>

    <form method="GET" action="{{ route('employees.index') }}" class="filter-row mb-4" id="filterForm">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search by Name" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="department_id" class="form-select">
                    <option value="">All Departments</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="manager_id" class="form-select">
                    <option value="">All Managers</option>
                    @foreach ($managers as $manager)
                        <option value="{{ $manager->id }}" @selected(request('manager_id') == $manager->id)>{{ $manager->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="joining_from" class="form-control" placeholder="Joining From" value="{{ request('joining_from') }}" title="Joining Date From">
            </div>
            <div class="col-md-2">
                <input type="date" name="joining_to" class="form-control" placeholder="Joining To" value="{{ request('joining_to') }}" title="Joining Date To">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-outline-secondary w-100">Apply</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Employee Name</th>
                    <th>Employee Code</th>
                    <th>Department</th>
                    <th>Manager</th>
                    <th>Joined Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td>
                            <a href="#" class="employee-name-link edit-employee"
                               data-id="{{ $employee->id }}"
                               data-full-name="{{ $employee->full_name }}"
                               data-employee-code="{{ $employee->employee_code }}"
                               data-department-id="{{ $employee->department_id }}"
                               data-manager-id="{{ $employee->manager_id }}"
                               data-joining-date="{{ $employee->joining_date->format('Y-m-d') }}"
                               data-email="{{ $employee->email }}"
                               data-phone="{{ $employee->phone }}"
                               data-address="{{ $employee->address }}">
                                {{ $employee->full_name }}
                            </a>
                        </td>
                        <td>{{ $employee->employee_code }}</td>
                        <td>{{ $employee->department->name }}</td>
                        <td>{{ $employee->manager->name }}</td>
                        <td>{{ $employee->joining_date->format('m/d/Y') }}</td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-edit edit-employee"
                                    data-id="{{ $employee->id }}"
                                    data-full-name="{{ $employee->full_name }}"
                                    data-employee-code="{{ $employee->employee_code }}"
                                    data-department-id="{{ $employee->department_id }}"
                                    data-manager-id="{{ $employee->manager_id }}"
                                    data-joining-date="{{ $employee->joining_date->format('Y-m-d') }}"
                                    data-email="{{ $employee->email }}"
                                    data-phone="{{ $employee->phone }}"
                                    data-address="{{ $employee->address }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-delete delete-employee"
                                    data-id="{{ $employee->id }}"
                                    data-name="{{ $employee->full_name }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($employees->hasPages())
        <div class="d-flex justify-content-center mt-4 pagination-custom">
            {{ $employees->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@include('employees.partials.form-modal')

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteEmployeeName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    @foreach (request()->only(['search', 'department_id', 'manager_id', 'joining_from', 'joining_to', 'page']) as $key => $value)
                        @if ($value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const employeeModal = document.getElementById('employeeModal');
    const employeeForm = document.getElementById('employeeForm');
    const methodField = document.getElementById('methodField');
    const modalTitle = document.getElementById('employeeModalLabel');
    const storeUrl = @json(route('employees.store'));
    const updateUrlTemplate = @json(route('employees.update', ['employee' => '__ID__']));
    const destroyUrlTemplate = @json(route('employees.destroy', ['employee' => '__ID__']));

    function openAddModal() {
        modalTitle.textContent = 'Add Employee';
        employeeForm.action = storeUrl;
        methodField.innerHTML = '';
        document.getElementById('employee_id').value = '';
        employeeForm.reset();
        clearValidation();
    }

    function openEditModal(button) {
        modalTitle.textContent = 'Edit Employee';
        const id = button.dataset.id;
        document.getElementById('employee_id').value = id;
        employeeForm.action = updateUrlTemplate.replace('__ID__', id);
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('full_name').value = button.dataset.fullName || '';
        document.getElementById('employee_code').value = button.dataset.employeeCode || '';
        document.getElementById('department_id').value = button.dataset.departmentId || '';
        document.getElementById('manager_id').value = button.dataset.managerId || '';
        document.getElementById('joining_date').value = button.dataset.joiningDate || '';
        document.getElementById('email').value = button.dataset.email || '';
        document.getElementById('phone').value = button.dataset.phone || '';
        document.getElementById('address').value = button.dataset.address || '';
        clearValidation();
        new bootstrap.Modal(employeeModal).show();
    }

    function clearValidation() {
        employeeForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    document.getElementById('addEmployeeBtn').addEventListener('click', openAddModal);

    document.querySelectorAll('.edit-employee').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            openEditModal(this);
        });
    });

    document.querySelectorAll('.delete-employee').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            document.getElementById('deleteEmployeeName').textContent = this.dataset.name;
            document.getElementById('deleteForm').action = destroyUrlTemplate.replace('__ID__', id);
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    @if ($errors->any())
        new bootstrap.Modal(employeeModal).show();
        @if (old('employee_id'))
            const editId = @json(old('employee_id'));
            employeeForm.action = updateUrlTemplate.replace('__ID__', editId);
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            modalTitle.textContent = 'Edit Employee';
            document.getElementById('employee_id').value = editId;
        @endif
    @endif
</script>
@endpush
