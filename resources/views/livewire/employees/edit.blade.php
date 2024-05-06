<div wire:ignore.self>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edit Employee</title>
    <form wire:submit.prevent="save" action="#">


        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">

            <h1>Edit Employee</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">General information</h2>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <div>
                                <label for="id">ID</label>
                                <input class="form-control" type="text" disabled value="{{ $user->id }}">


                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div>
                                <label for="name">Name</label>
                                <input class="form-control" id="name" type="text"
                                    placeholder="Enter Employee's Name" value="{{ $user->name }}" wire:model="name">

                            </div>
                        </div>

                        <div class="col-md-5 mb-3">
                            <div>
                                <label for="username">Username</label>
                                <input class="form-control" id="username" type="text" wire:model="username"
                                    value="{{ $user->username }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <div>

                                <label for="comapny">Company</label>
                                <select class="form-select mb-0" id="company_id" aria-label="company select example"
                                    wire:model="company_id" autofocus required>
                                    @foreach ($companies as $comp)
                                        <option value="{{ $comp->id }}"
                                            {{ $comp->id == $user->company_id ? 'selected' : '' }}>
                                            {{ $comp->name }} </option>
                                    @endforeach


                                </select>
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="name">Department</label>
                                <select class="form-select mb-0" id="department_id"
                                    aria-label="department select example" wire:model="department_id">
                                    @foreach ($departments as $dept)
                                        <option {{ $user->dept == $dept->id ? 'selected' : '' }}
                                            value="{{ $dept->id }}">
                                            {{ $dept->name }} </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="position">Position</label>
                            <div class="input-group">



                                <select class="form-select mb-0" id="position" aria-label="position select example"
                                    wire:model="position" autofocus required>
                                    <option hidden selected>Select Employee's Postion</option>


                                    <option value="employee" {{ $user->position == 'employee' ? 'selected' : '' }}>
                                        Employee</option>
                                    <option value="manager" {{ $user->position == 'manager' ? 'selected' : '' }}>
                                        Manager</option>


                                </select>


                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>




                        <div class="col-md-5 mb-3">
                            <label for="position">Employee Type</label>
                            <div class="input-group">


                                <select class="form-select mb-0" id="type" aria-label="type select example"
                                    wire:model="type" autofocus required>
                                    <option hidden selected>Select Employee's Type</option>

                                    <option value="full-time" {{ $user->type == 'full-time' ? 'selected' : '' }}>
                                        Full-time</option>
                                    <option value="part-time" {{ $user->type == 'part-time' ? 'selected' : '' }}>
                                        Part-time</option>

                                </select>


                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>


                        @if ($this->type == 'part-time')
                            <div class="col-md-5 mb-3">
                                <label for="position">Part Time Period</label>
                                <div class="input-group">


                                    <select class="form-select mb-0" id="part_time"
                                        aria-label="part_time select example" wire:model="part_time">
                                        <option value="" selected>Select Employee's part time period</option>

                                        <option value="daily" {{ $user->part_time == 'daily' ? 'selected' : '' }}>
                                            Daily</option>
                                        <option value="weekly" {{ $user->part_time == 'weekly' ? 'selected' : '' }}>
                                            Weekly</option>
                                        <option value="monthly" {{ $user->part_time == 'monthly' ? 'selected' : '' }}>
                                            Monthly</option>

                                    </select>


                                    @error('part_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        @endif




                        <div class="col-md-6 mb-3">
                            <label for="role">Role</label>
                            <div class="input-group">


                                <select class="form-select mb-0" id="role" aria-label="role select example"
                                    wire:model="role" autofocus required>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $this->user->hasRole($role->name) ? ' selected' : '' }}>
                                            {{ $role->name }} </option>
                                    @endforeach

                                </select>


                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>




                        <div class="col-md-5 mb-3">
                            <label for="start_date">Start Date</label>
                            <div class="input-group">

                                <input class="form-control datepicker-input" type="date" id="start_date"
                                    placeholder="Enter Employee's start_date" wire:model="start_date" autofocus
                                    required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>




                    </div>



                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3">
                            <label for="birthday">Birthday</label>
                            <div class="input-group">

                                <input class="form-control datepicker-input" type="date" id="birthday"
                                    value="{{ $user->birthday }}" wire:model="birthday">
                                @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender">Gender</label>
                            <select class="form-select mb-0" id="gender" aria-label="Gender select example"
                                wire:model="gender">
                                <option value="Male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="ID_no" autofocus required>ID Number</label>
                            <div class="input-group">

                                <input class="form-control datepicker-input" value="{{ $user->ID_no }}"
                                    type="text" id="ID_no" placeholder="Enter Employee's National ID"
                                    wire:model="ID_no">
                                @error('ID_no')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror

                            </div>
                        </div>



                    </div>

                    <div class="row">
                        <h2 class="h5 my-4">Salar information</h2>

                        <div class="col-md-6 mb-3">
                            <label for="salary">Salary</label>
                            <div class="input-group">

                                <input class="form-control datepicker-input" type="text" id="salary"
                                    placeholder="Enter Employee's salary" wire:model="salary" autofocus required>
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bank">Bank</label>
                            <div class="input-group">

                                <select class="form-select mb-0" id="bank" aaria-label="bank select example"
                                    wire:model="bank" autofocus required>
                                    <option value="" disabled selected hidden>Select Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}"
                                            {{ $this->bank == $bank->id ? 'checked' : '' }}>{{ $bank->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bank')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="IBAN">IBAN</label>
                            <div class="input-group">

                                <input class="form-control datepicker-input" type="text" id="IBAN"
                                    placeholder="Enter Employee's IBAN" wire:model="IBAN" autofocus required>
                                @error('IBAN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>




                    </div>


                    

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" wire:model="email"
                                    value="{{ $user->email }}">
                                @error('email')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input class="form-control" id="phone" type="number"
                                    placeholder="+962790000000" value="{{ $user->phone }}" wire:model="phone">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <h2 class="h5 my-4">Location</h2>
                    <div class="row">
                        <div class="col-sm-9 mb-3">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input class="form-control" id="address" type="text"
                                    placeholder="Enter Employee's home address" wire:model="address">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <div style="position: relative" class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" id="password" type="password"
                                    placeholder="Enter Employee's  password" wire:model="password">
                                    <i id="pass1" onclick="hidepass()" style="position: absolute;right: 10px;top: 41px;display:none;cursor:pointer" class="fa-solid fa-eye"></i>
                                    <i id="pass2" onclick="showpass()" style="position: absolute;right: 10px;top: 41px;cursor:pointer" class="fa-solid fa-eye-slash"></i>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
<script>
    function showpass(){
        $("#password").attr("type","text");
        $("#pass1").show();
        $("#pass2").hide();
    }
    function hidepass(){
        $("#password").attr("type","password");
        $("#pass1").hide();
        $("#pass2").show();
    }
</script>
                            </div>
                        </div>
                        <div class="col-md-7 mb-3">
                            <h2 class="h5 my-4">He wants to participate in Social Security</h2>
                            <div class="form-group">
                                <label class="form-check-label" for="user-notification-1"></label>
                                <div class="form-check form-switch">
                                    <input style="width:40px" class="form-check-input" type="checkbox"
                                        id="status" wire:model="social_security" checked="false">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-12">
                        <div class="card card-body border-0 shadow mb-4 mb-xl-0">
                            <h2 class="h5 mb-4">Employment</h2>



                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                                    <div>
                                        <h3 class="h6 mb-1">Active</h3>
                                        <p class="small pe-4">Employment / Unemployment</p>
                                    </div>



                                    <div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status"
                                                wire:model="status" {{ $user->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="user-notification-1"></label>
                                        </div>
                                    </div>
                                </li>


                            </ul>


                            @if ($this->status != 1)
                                <div class="form-group">
                                    <label for="unemployment">End date</label>
                                    <input class="form-control" id="unemployment" type="date"
                                        placeholder="Enter Employee's home unemployment Date"
                                        wire:initial="unemployment" wire:model="unemployment">
                                    @error('unemployment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2">Save All</button>
                    </div>

                </div>

            </div>



            <div class="col-12 col-xl-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow border-0 text-center p-0">

                            <div class="card-body pb-5">

                                @if ($newImage)
                                    <img src="{{ $newImage }}" class="avatar-xl rounded-circle mx-auto mb-4"
                                        alt="{{ $user->name }} Profile Pic">
                                @elseif($user->image)
                                    <img src="/storage/profile/{{ $user->image }}"
                                        class="avatar-xl rounded-circle mx-auto mb-4"
                                        alt="{{ $user->name }} Profile Pic">
                                @endif


                                <h4 class="h3">{{ $user->name }}</h4>
                                <h5 class="fw-normal">{{ $user->position }}</h5>
                                <p class="text-gray mb-4">Start Date: {{ $user->start_date }}</p>
                                <div class="col-sm-10 mb-3 ">
                                    <label for="formFile" class="form-label">upload Employee's image</label>
                                    <input class="form-control" type="file" id="image" wire:model="image">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <div class="card shadow border-0 text-center p-0">

                            <div class="card-body pb-5">
                                <h4 class="h3">Contract</h4>

                                @if ($this->contract)
                                    <embed src="{{ route('viewContract', ['filename' => $this->contract]) }}"
                                        type="application/pdf" width="100%" height="600px"
                                        class="avatar-xxl mx-auto" />
                                    <a class="mb-4"style="color: #3892ff;"
                                        href="{{ route('viewContract', ['filename' => $this->contract]) }}"
                                        target="_blank">open Contract in new tab</a>
                                @endif








                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="signedDate">Sgined date</label>
                                        <input class="form-control" id="signedDate" type="date"
                                            placeholder="Enter Employee's home signedDate" wire:model="signedDate">
                                        @error('signedDate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3 ">
                                    <label for="formFile" class="form-label">upload new Contract's copy</label>
                                    <input class="form-control" type="file" id="newContract"
                                        wire:model="newContract">
                                    @error('newContract')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="row flex-column">
                                    <h1>Duration of the Contract</h1>
                                    <div class="" style="display: flex;justify-content: space-evenly;">
                                        <h5 class="">3 month
                                            <input class="form-check-input" wire:model="Duration_contract"
                                                value="0" type="radio" id="contrctYear"
                                                name="Duration_contract">
                                        </h5>
                                        <h5 class="">1 year
                                            <input class="form-check-input" wire:model="Duration_contract"
                                                value="1" id="contrctMonth" type="radio"
                                                name="Duration_contract">
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="align-items-center card shadow border-0 text-center p-0">

                            <div class="card-body pb-5">
                                <h4 class="h3">Employee's ID card image</h4>

                                @if ($newID_image)
                                    <img src="{{ $newID_image }}" class="avatar-xxl  mx-auto mb-4" alt="ID Image">
                                @elseif($user->ID_image)
                                    <img src="/storage/profile/{{ $user->ID_image }}" class="avatar-xxl mx-auto mb-4"
                                        alt="ID Image">
                                    <a href="/storage/profile/{{ $user->ID_image }}" target="_blangk"
                                        class="mb-4"style="color: #3892ff;"> open Image in new tab </a>
                                @endif




                            </div>
                            <div class="col-sm-10 mb-3 mt-4">
                                <label for="formFile" class="form-label">upload new Employee's ID card image</label>
                                <input class="form-control" type="file" id="ID_image" wire:model="ID_image">
                                @error('ID_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <!-- End of Form -->
                        </div>
                    </div>




                    <div class="col-12 mb-3">
                        <div class="align-items-center card shadow border-0 text-center p-0">

                            <div class="card-body pb-5">

                                @if ($newLicense_image)
                                    <img src="{{ $newLicense_image }}" class="avatar-xxl  mx-auto " alt="ID Image">
                                @elseif($user->license_image)
                                    <img src="/storage/profile/{{ $user->license_image }}"
                                        class="avatar-xxl mx-auto mb-4" alt="License Image">
                                    <a href="/storage/profile/{{ $user->license_image }}" target="_blangk"
                                        class="mb-4"style="color: #3892ff;"> open Image in new tab </a>
                                @endif

                                <h4 class="h3">Employee's License image</h4>

                            </div>
                            <div class="col-sm-10 mb-3 mt-4">
                                <label for="formFile" class="form-label">upload Employee's License image</label>
                                <input class="form-control" type="file" id="license_image"
                                    wire:model="license_image">
                                @error('ID_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <!-- End of Form -->
                        </div>
                    </div>


                </div>
            </div>
            @if ($showSavedAlert)
                <div class="alert alert-success" role="alert">
                    Saved!
                </div>
            @endif

            @if ($showDemoNotification)
                <div class="alert alert-info mt-2" role="alert">
                    You cannot do that in the demo version.
                </div>
            @endif
        </div>
</div>
</form>
</div>
