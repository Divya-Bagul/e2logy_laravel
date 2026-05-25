<div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered employee-modal-dialog">
        <div class="modal-content employee-modal-content">
            <form id="employeeForm" method="POST" action="{{ route('employees.store') }}" class="employee-modal-form" novalidate>
                @csrf
                <input type="hidden" id="employee_id" name="employee_id" value="{{ old('employee_id') }}">
                <div id="methodField"></div>
                <div class="modal-header flex-shrink-0">
                    <h5 class="modal-title" id="employeeModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body employee-modal-body">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}">
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="employee_code" class="form-label">Employee Code</label>
                        <input type="text" class="form-control @error('employee_code') is-invalid @enderror" id="employee_code" name="employee_code" value="{{ old('employee_code') }}">
                        @error('employee_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="manager_id" class="form-label">Manager</label>
                        <select class="form-select @error('manager_id') is-invalid @enderror" id="manager_id" name="manager_id">
                            <option value="">Select Manager</option>
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->id }}" @selected(old('manager_id') == $manager->id)>{{ $manager->name }}</option>
                            @endforeach
                        </select>
                        @error('manager_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="joining_date" class="form-label">Joining Date</label>
                        <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" name="joining_date" value="{{ old('joining_date') }}">
                        @error('joining_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Address">{{ old('address') }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer flex-shrink-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>
