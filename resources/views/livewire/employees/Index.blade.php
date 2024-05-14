<div>
    <title>Employees</title>
    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <div class="input-group me-2 me-lg-3 fmxw-400">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search Employee">
                </div>
            </div>
            <div class="ol col-md-7 col-lg-3 col-xl-4">
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('employees.create') }}"
                        class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                        <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                            </path>
                        </svg>
                        New Employee
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">ID</th>
                    <th class="border-gray-200">Name</th>
                    <th class="border-gray-200">Company</th>
                    <th class="border-gray-200">Department</th>
                    <th class="border-gray-200">Position</th>
                    <th class="border-gray-200">type</th>
                    <th class="border-gray-200">Status</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $user->id }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="d-flex align-items-center">
                                <span class="fw-bold">{{ $user->name }}</span>
                            </a>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $user->company_name }}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $user->department_name }}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $user->position }}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $user->type }}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">

                                {!! $user->status == 1
                                    ? '<span class="fw-bold text-success">Active</span>'
                                    : '<span class="fw-bold text-danger">Inactive</span>' !!}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            <div class="btn-group">
                                <a class="dropdown-item"
                                    href="{{ route('employees.edit', ['user' => $user->id]) }}"><span
                                        class="fas fa-edit me-2"></span>Edit</a>
                                <a class="dropdown-item"
                                    href="{{ route('employees.view', ['user' => $user->id]) }}"><span
                                        class="fas fa-eye me-2"></span>View</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $users->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
