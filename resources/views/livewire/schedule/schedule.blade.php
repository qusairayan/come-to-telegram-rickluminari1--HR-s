<div>
    <title>Schedule </title>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Schedule</li>
                </ol>
            </nav>
            <h2 class="h4">Staff Schedule</h2>
        </div>

    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <div class="row">
            @if (auth()->user()->hasPermissionTo('setSchedule'))
                <!-- Form -->
                <div class="col-md-4 mb-3">
                    <div>
                        <label for="comapny">Company</label>
                        <select class="form-select mb-0" id="company" aria-label="company select example"
                            wire:model="company" autofocus required>
    
                            <option value=""selected>Select Employee's Company</option>
                            @foreach ($companies as $comp)
                                <option value="{{ $comp->id }}">
                                    {{ $comp->name }} </option>
                            @endforeach
    
    
                        </select>
                        @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
    
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <label class="my-1 me-2" for="department">Department</label>
                    <select class="form-select" id="department" aria-label="Default select example"
                        wire:model="department">
                        @foreach ($departments as $department)
                            <option selected value="{{ $department->id }}"
                                {{ $department->id == auth()->user()->department_id ? 'selected' : '' }}>
                                {{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- End of Form -->
            @endif

            <!-- Form -->

            <div class="col-md-4 mb-4">
                <label class="my-1 me-2" for="user">Staff</label>
                <select class="form-select" id="user" wire:model="user" aria-label="Default select example">
                    <option hidden selected value="">Select Employee</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- End of Form -->
        </div>
        <div class="row">

            <!-- Form -->
            <div class="col-md-5 mb-4">
                <div class="mb-3">
                    <label class="my-1 me-2" for="dateFrom">Date From</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <input class="form-control" id="dateFrom" type="date" wire:model="dateFrom">
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="mb-3">
                    <label class="my-1 me-2" for="dateTo">Date To</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <input class="form-control" id="dateTo" type="date" placeholder="dd/mm/yyyy"
                            wire:model="dateTo">
                    </div>
                </div>

                @error('dateFrom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('dateTo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0 rounded-start">Day</th>
                                <th class="border-0">Date</th>
                                <th class="border-0">From</th>
                                <th class="border-0">To</th>
                                <th class="border-0">Action</th>
                                <th class="border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schdules as $schdule)
                                <tr>
                                    <td class="fw-bold align-items-center">{{ $schdule->day }} </td>
                                    <td class="fw-bold align-items-center">
                                        {{ $schdule->date }}
                                    </td>
                                    @if ($schdule->from == null)
                                        <td colspan="2" class="fw-bold align-items-center text-danger">
                                            Off
                                        </td>
                                    @else
                                        <td class="fw-bold align-items-center ">
                                            {{ \Carbon\Carbon::parse($schdule->from)->format('h:i A') }}
                                        </td>
                                        <td class="fw-bold align-items-center ">
                                            {{ \Carbon\Carbon::parse($schdule->to)->format('h:i A') }}
                                        </td>
                                    @endif
                                    @if ($schdule->date > date('Y-m-d'))
                                        <td class="fw-bold align-items-center">
                                            <div class="col-md-3 col-12 btn-toolbar mb-2 mb-md-0">
                                                <a wire:click="edit({{ $schdule->user_id }}, '{{ $user->name }}','{{ $schdule->from }}','{{ $schdule->to }}','{{ $schdule->id }}','{{ $schdule->off }}','{{ $schdule->date }}')"
                                                    data-bs-toggle="modal" data-bs-target="#modal-notification"
                                                    class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                                                    Edit
                                                </a>

                                            </div>
                                            {{-- <button wire:click="edit" class="btn btn-success text-transparent">edit</button>  --}}
                                        </td>
                                        <td class="fw-bold align-items-center"> <button wire:click="delete({{$schdule->id}})"
                                                class="btn btn-danger text-transparent">delete</button> </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div>
                        {{ $schdules->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>
            <!-- End of Form -->


        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal-notification" tabindex="-1" role="dialog"
        aria-labelledby="modal-notification" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-info modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-secondary" style="background: #13223d">
                <button type="button" class="btn-close theme-settings-close fs-6 ms-auto" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header">
                    <p class="modal-title text-gray-200" id="modal-title-notification">
                        Edit Schedule
                    </p>
                </div>
                <form wire:submit.prevent="save">
                    <div class="row p-md text-white">
                    </div>
                    <div class="modal-body text-white">
                        <div class="py-1 text-start">
                            <h4 class="h5 py-2">Employee Name:</h4>
                            <div class="input-group mt-1">
                                <input class="form-control" type="text" disabled value="{{ $name }}">
                            </div>
                        </div>
                        <div class="py-1 text-start">
                            <h4 class="h5 py-2">date:</h4>
                            <div class="input-group mt-1">
                                <input type="date" wire:model="editDate" disabled value="{{ $editDate }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="py-1 text-start">
                            <h4 class="h5 py-2">From:</h4>
                            <div class="input-group mt-1">
                                <input type="time" wire:model="editFrom" value="{{ $editFrom }}"
                                    class="form-control">
                            </div>
                            @error('editFrom')
                                <div class="invalid-feedback py-2"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="py-1 text-start">
                            <h4 class="h5 py-2">To:</h4>
                            <div class="input-group mt-1">
                                <input type="time" wire:model="editTo" value="{{ $editTo }}"
                                    class="form-control">
                            </div>
                            @error('editTo')
                                <div class="invalid-feedback py-2"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="py-1 text-start d-flex w-100">
                            <h4 style="flex: 50%" class="h5 py-2">Off Day:</h4>
                            <div class="input-group mt-1">
                                <input type="checkbox" {{$off == true ? 'checked' : ''}}  wire:model="off" value="{{ $off }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Edit</button>
                    </div>
                </form>


            </div>
        </div>
    </div>


</div>
