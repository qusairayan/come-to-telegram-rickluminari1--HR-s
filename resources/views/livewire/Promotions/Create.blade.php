<main>

    <form wire:submit.prevent="create" action="#" method="POST">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <h1>Add New Promotion</h1>
        </div>
        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">General information</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="name">Company</label>
                    <select class="form-select mb-0" id="company" aria-label="company select example"
                        wire:model="company" autofocus>
                        <option selected>Select Employee's Company</option>
                        @foreach ($companies as $comp)
                            <option value="{{ $comp->id }}">
                                {{ $comp->name }} </option>
                        @endforeach
                    </select>
                    @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="department">Department</label>
                    <select class="form-select mb-0" id="department" aria-label="department select example"
                        wire:model="department" autofocus {{ $this->company == '' ? 'disabled' : '' }}>
                        <option selected>Select Employee's Department</option>
                        @foreach ($departments as $dep)
                            <option value="{{ $dep->id }}">
                                {{ $dep->name }} </option>
                        @endforeach
                    </select>
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="position">Position</label>
                    <div class="input-group">
                        <select class="form-select mb-0" id="position" aria-label="position select example"
                            wire:model="position" autofocus required>
                            <option value="" disabled selected hidden>Select Employee's Postion
                            <option value="employee">Employee</option>
                            <option value="manager">Manager</option>
                            <option value="Chief financial officer (CFO)">Chief financial officer (CFO)</option>
                            <option value="Chief operating officer (COO)">Chief operating officer (COO)</option>
                            <option value="Chief information officer (CIO)">Chief information officer (CIO)</option>
                            <option value="Chief technology officer (CTO)">Chief technology officer (CTO)</option>
                            <option value="Chief marketing officer (CMO)">Chief marketing officer (CMO)</option>
                            <option value="Chief administrative officer (CAO)">Chief administrative officer (CAO)</option>
                            <option value="Chief risk officer (CRO)">Chief risk officer (CRO)</option>
                            <option value="Team lead">Team lead</option>
                            <option value="Coordinator">Coordinator</option>
                            <option value="Senior">Senior</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Assistant manager">Assistant manager</option>
                            <option value="Senior manager">Senior manager</option>
                            <option value="HR Director">HR Director</option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="user">Employee</label>
                    {{-- <select class="form-select mb-0" {{ $this->department == '' ? 'disabled' : '' }} id="user" --}}
                    <select class="form-select mb-0" id="user"
                        aria-label="user select example" wire:model="user" autofocus>
                        <option selected>Select Employee</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} </option>
                        @endforeach
                    </select>
                    @error('user')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="position">Employee Type</label>
                    <div class="input-group">
                        <select class="form-select mb-0" id="type" aria-label="type select example"
                            wire:model="type" autofocus required>
                            <option value="" disabled selected hidden>Select Employee's Type
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
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="salary">Salary</label>
                    <div class="input-group">
                        <input class="form-control datepicker-input" type="text" id="salary"
                            placeholder="Enter Employee's salary" wire:model="salary" autofocus>
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="start_date">Start Date</label>
                    <div class="input-group">
                        <input class="form-control datepicker-input" type="date" id="from"
                            placeholder="Enter Employee's start_date" wire:model="from" autofocus>
                        @error('from')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="start_date">end Date</label>
                    <div class="input-group">
                        <input class="form-control datepicker-input" type="date" id="from"
                            placeholder="Enter Employee's start_date" wire:model="end" autofocus>
                        @error('end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2" wire:loading.attr="disabled">Save
                    All</button>
            </div>
        </div>
        </div>
    </form>
</main>
