<div>
    <form wire:submit.prevent="update" action="#" method="POST">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <h1>Edit Promotion</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">General information</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div>
                                <label for="user">Employee</label>
                                <select class="form-select mb-0" disabled id="user"
                                    aria-label="user select example" autofocus>
                                    <option selected>{{ $name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Company</label>
                            <select class="form-select mb-0" id="company" aria-label="company select example"
                                wire:model="company" autofocus required>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ $company == $company->name ? 'selected' : '' }} >{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="position">Position</label>
                            <div class="input-group">
                                <select class="form-select mb-0" id="position" aria-label="position select example"
                                    wire:model="position" autofocus="" required="">
                                    <option value="employee">Employee</option>
                                    <option value="manager">Manager</option>
                                    <option value="Chief financial officer (CFO)">Chief financial officer (CFO)</option>
                                    <option selected value="Chief operating officer (COO)">Chief operating officer (COO)</option>
                                    <option value="Chief information officer (CIO)">Chief information officer (CIO)
                                    </option>
                                    <option value="Chief technology officer (CTO)">Chief technology officer (CTO)
                                    </option>
                                    <option value="Chief marketing officer (CMO)">Chief marketing officer (CMO)</option>
                                    <option value="Chief administrative officer (CAO)">Chief administrative officer
                                        (CAO)</option>
                                    <option value="Chief risk officer (CRO)">Chief risk officer (CRO)</option>
                                    <option value="Team lead">Team lead</option>
                                    <option value="Coordinator">Coordinator</option>
                                    <option value="Senior">Senior</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Assistant manager">Assistant manager</option>
                                    <option value="Senior manager">Senior manager</option>
                                    <option value="HR Director">HR Director</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="department">Department</label>
                            <select class="form-select mb-0" id="department" aria-label="department select example"
                                wire:model="department" autofocus="">
                                @foreach ($departments as $departmenti)
                                <option
                                 {{-- {{ $department == $department->name ? 'selected' : '' }} --}}
                                    value="{{ $departmenti->id }}">{{ $departmenti->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="position">Employee Type</label>
                            <div class="input-group">
                                <select class="form-select mb-0" id="type" aria-label="type select example"
                                    wire:model="type" autofocus="" required="">
                                    <option value="" disabled="" selected="" hidden="">Select
                                        Employee's Type
                                    </option>
                                    <option value="full-time">Full-time</option>
                                    <option value="part-time">Part-time</option>
                                </select>
                            </div>
                        </div>
                        @if ($type == 'part-time')
                        <div class="col-md-4 mb-3">
                            <label for="position">Part Time Period</label>
                            <div class="input-group">
                                <select class="form-select mb-0" id="part_time" aria-label="part_time select example"
                                    wire:model="part_time" autofocus required>
                                    <option value="" selected>Select Employee's part time period</option>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                                @error('part_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif
                        <div class="col-md-4 mb-3">
                            <label for="salary">Salary</label>
                            <div class="input-group">
                                <input class="form-control datepicker-input" type="text" id="salary"
                                     wire:model="salary" autofocus
                                    >
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start_date">Satrt Date</label>
                            <div class="input-group">
                                <input class="form-control datepicker-input" type="date" id="from"
                                    placeholder="Enter Employee's start_date" wire:model="from" disabled autofocus
                                    value="{{ $from }}">
                                @error('from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start_date">End Date</label>
                            <div class="input-group">
                                <input class="form-control datepicker-input" type="date" id="from"
                                    min="{{$from}}" wire:model="to" autofocus
                                    value="{{ $to }}">
                                @error('to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2"
                            wire:loading.attr="disabled">Save All</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
