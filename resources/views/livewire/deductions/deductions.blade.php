<div>
    <title>Deductions</title>

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
                    <li class="breadcrumb-item active" aria-current="page">Deduction</li>
                </ol>
            </nav>
            <h2 class="h4">All Deductions</h2>
        </div>

    </div>
    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <div class="input-group me-2 me-lg-3 fmxw-400">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search Employee">

                </div>
            </div>


            <div class="col-md-3 col-12 btn-toolbar mb-2 mb-md-0">
                <a data-bs-toggle="modal" data-bs-target="#modal-notification"
                    class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Add Deduction
                </a>

            </div>


            <div class="col-md-3 col-12 btn-toolbar mb-2 mb-md-0">
                <a data-bs-toggle="modal" data-bs-target="#modal-addTypeDeduction"
                    class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Add Deduction Type
                </a>

            </div>




            <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
                <div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
                        <span class="small ps-3 fw-bold text-dark">Show</span>
                        <a class="dropdown-item d-flex align-items-center fw-bold" href="#">10 <svg
                                class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                        <a class="dropdown-item fw-bold" href="#">20</a>
                        <a class="dropdown-item fw-bold rounded-bottom" href="#">30</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>

                    <th class="border-gray-200">Name</th>
                    <th class="border-gray-200">Department</th>
                    <th class="border-gray-200">type</th>
                    <th class="border-gray-200">date</th>
                    <th class="border-gray-200">Amount <small>JD</small></th>
                    <th class="border-gray-200">Action</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($violations as $violation)
                <tr>
                    <td>
                        <a href="#" class="d-flex align-items-center">

                            <div class="d-block">
                                <span class="fw-bold">{{ $violation->name }}</span>
                            </div>
                        </a>
                    </td>
                    <td class="border-0 fw-bold">
                        <span class="fw-normal">
                            Driver
                        </span>
                    </td>
                    <td class="border-0 fw-bold">
                        <span class="fw-normal">
                            مخالفات السير
                        </span>
                    </td>
                    <td class="border-0 fw-bold">
                        <span class="fw-normal">
                            {{ $violation->date }}
                        </span>
                    </td>
                    <td class="border-0 fw-bold">
                        <span class="fw-normal">
                            {{ $violation->amount }}
                        </span>
                    </td>
                    <td class="border-0 fw-bold">
                        @if ($violation->status == 0)
                            <div class="btn-group">
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    wire:click="approveTrafic({{ $violation }})" type="button">Approve</button>
                            </div>
                        @else
                            <span class="badge text-white bg-success">Approved</span>
                        @endif

                    </td>

                    <td class="border-0 fw-bold">
                        @if ($deduction->status == 0)
                            <div class="btn-group">
                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    wire:click="delete({{ $violation->id }})" type="button">Delete</button>
                            </div>
                        @else
                            <span wire:click="delete({{ $violation->id }})" type="button"
                                class="badge text-white bg-danger">delete</span>
                        @endif
                    </td>


                </tr>
            @endforeach
                @foreach ($deductions as $deduction)
                    <tr>
                        <td>
                            <a href="#" class="d-flex align-items-center">

                                <div class="d-block">
                                    <span class="fw-bold">{{ $deduction->name }}</span>
                                </div>
                            </a>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $deduction->department }}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                @if ($deduction->type)
                                    {{ $deduction->type }}
                                @endif
                            </span>
                        </td>


                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $deduction->date }}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            <span class="fw-normal">
                                {{ $deduction->amount }}
                            </span>
                        </td>
                        <td class="border-0 fw-bold">
                            @if ($deduction->status == 0)
                                <div class="btn-group">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        wire:click="approve({{ $deduction->id }})" type="button">Approve</button>
                                </div>
                            @else
                                <span class="badge text-white bg-success">Approved</span>
                            @endif

                        </td>

                        <td class="border-0 fw-bold">
                            @if ($deduction->status == 0)
                                <div class="btn-group">
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        wire:click="delete({{ $deduction->id }})" type="button">Delete</button>
                                </div>
                            @else
                                <span wire:click="delete({{ $deduction->id }})" type="button"
                                    class="badge text-white bg-danger">delete</span>
                            @endif
                        </td>


                    </tr>
                @endforeach




            </tbody>
        </table>
        <div>
            {{ $deductions->links('vendor.pagination.custom') }}
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
                        Add Deductions
                    </p>
                </div>
                <form wire:submit.prevent="addDeduction">
                    <div class="row p-md text-white">

                    </div>

                    <div class="modal-body text-white">
                        <div class="py-1 text-start">

                            <h4 class="h5 py-2">User Name:</h4>

                            <div class="input-group mt-1">
                                <select class="mt-2 mb-2 form-control" wire:model="userId">{{ $userId }}
                                    <option value="" hidden selected>select Employee</option>

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>


                                @error('userId')
                                    <div class="invalid-feedback py-2"> {{ $message }} </div>
                                @enderror

                            </div>

                        </div>


                        <div class="py-1 text-start">

                            <h4 class="h5 py-2">date:</h4>

                            <div class="input-group mt-1">
                                <input wire:model="date" type="date" class="form-control">
                            </div>
                            @error('date')
                                <div class="invalid-feedback py-2"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="py-1 text-start">

                            <h4 class="h5 py-2">amount:</h4>

                            <div class="input-group mt-1">
                                <input wire:model="amount" type="text" placeholder="amount" class="form-control">
                            </div>
                            @error('amount')
                                <div class="invalid-feedback py-2"> {{ $message }} </div>
                            @enderror
                        </div>


                        <div class="py-1 text-start">

                            <h4 class="h5 py-2">type:</h4>

                            <div class="input-group mt-1">
                                <select class="mt-2 mb-2 form-control" wire:model="type">
                                    <option value="" hidden selected>Deductions type</option>

                                    @foreach ($types as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('type')
                                <div class="invalid-feedback py-2"> {{ $message }} </div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Add Deductions</button>
                    </div>
                </form>


            </div>
        </div>
    </div>



    {{-- add type deedction --}}


    <div wire:ignore.self class="modal fade" id="modal-addTypeDeduction" tabindex="-1" role="dialog"
        aria-labelledby="modal-addTypeDeduction" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-info modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-secondary" style="background: #13223d">
                <button type="button" class="btn-close theme-settings-close fs-6 ms-auto" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header">
                    <p class="modal-title text-gray-200" id="modal-title-addTypeDeduction">
                        Add Deduction Type
                    </p>
                </div>










                <form wire:submit.prevent="addTypeDeduction">

                    <div class="modal-body text-white">
                        <div class="py-1 text-start">

                            <div class="py-1 text-start">

                                <h4 class="h5 py-2">Type Deduction:</h4>

                                <div class="input-group mt-1">
                                    <input wire:model="typeDeduction" type="text" class="form-control">
                                </div>
                                @error('typeDeduction')
                                    <div class="invalid-feedback py-2"> {{ $message }} </div>
                                @enderror
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Add Deduction Type</button>
                    </div>
                </form>

                <div style="padding: 1rem;width: 90%;margin:10px auto;background-color: white;overflow-y: scroll;max-height:100px"
                    class="box-item-dedction">
                    @foreach ($types as $item)
                        <div>{{ $item->name }}</div>
                    @endforeach
                </div>



            </div>
        </div>
    </div>
    {{-- add type deedction --}}






    <div wire:ignore.self class="modal fade" id="modal-edit" tabindex="-1" role="dialog"
        aria-labelledby="modal-edit" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-info modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-secondary" style="background: #13223d">
                <button type="button" class="btn-close theme-settings-close fs-6 ms-auto" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header">
                    <p class="modal-title text-gray-200" id="modal-title-edit">
                        Edit Deductions
                    </p>
                </div>





            </div>
        </div>
    </div>
</div>
