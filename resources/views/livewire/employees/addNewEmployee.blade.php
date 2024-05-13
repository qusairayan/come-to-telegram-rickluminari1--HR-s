<main>
    <style>
        .container {
          display: block;
          position: relative;
          padding-left: 35px;
          margin-bottom: 12px;
          cursor: pointer;
          font-size: 22px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
        }
        
        .container input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
          height: 0;
          width: 0;
        }
        
        .checkmark {
          position: absolute;
          top: 0;
          left: 0;
          height: 25px;
          width: 25px;
          background-color: #eee;
        }
        .container:hover input ~ .checkmark {
          background-color: #ccc;
        }
        
        .container input:checked ~ .checkmark {
          background-color: #2196F3;
        }
        
        .checkmark:after {
          content: "";
          position: absolute;
          display: none;
        }
        
        .container input:checked ~ .checkmark:after {
          display: block;
        }
        
        .container .checkmark:after {
          left: 9px;
          top: 5px;
          width: 5px;
          height: 10px;
          border: solid white;
          border-width: 0 3px 3px 0;
          -webkit-transform: rotate(45deg);
          -ms-transform: rotate(45deg);
          transform: rotate(45deg);
        }
        </style>
    <form wire:submit.prevent="add" action="#" method="POST">



        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">

            <h1>Add New Employee</h1>
        </div>

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">General information</h2>
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="name">Name</label>
                                <input class="form-control" id="name" type="text"
                                    placeholder="Enter Employee's Name" wire:model="name" autofocus required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <div>
                                <label for="username">Username</label>
                                <input class="form-control" id="username" type="text"
                                    placeholder="Enter Employee's Username" wire:model="username" autofocus required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div>
                                <label for="comapny">Company</label>
                                <select class="form-select mb-0" id="company" aria-label="company select example"
                                    wire:model="company" autofocus required>
                                    <option value=""  selected >Select Employee's Company
                                    </option>

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

                        <div class="col-md-5 mb-3">
                            <div>
                                <label for="department">Department</label>
                                <select class="form-select mb-0" id="department" aria-label="department select example"
                                    wire:model="department" autofocus required>
                                    
                                    <option value="" selected >Select Employee's Department
                                    </option>@foreach ($departments as $dept)

                                        <option value="{{ $dept->id }}">
                                            {{ $dept->name }} - {{ $dept->company_name }}</option>
                                    @endforeach
                                  

                                </select>
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>


                        <div class="col-md-5 mb-3">
                            <label for="position">Position</label>
                            <div class="input-group">


                                <select class="form-select mb-0" id="position" aria-label="position select example"
                                    wire:model="position" autofocus required>
                                    <option value="" disabled selected hidden>Select Employee's Postion

                                    <option value="employee">Employee</option>
                                    <option value="manager">Manager</option>



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
                                    <option value="" disabled selected hidden>Select Employee's Type

                                    <option value="full-time">Full-time</option>
                                    <option value="part-time">Part-time</option>

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
                                        aria-label="part_time select example" wire:model="part_time" autofocus required>
                                        <option value=""  selected >Select Employee's part time period</option>

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




                        <div class="col-md-5 mb-3">
                            <label for="role">Role</label>
                            <div class="input-group">


                                <select class="form-select mb-0" id="role" aria-label="role select example"
                                    wire:model="role" autofocus required>
                                    
                                    <option value="" selected>Select Employee's Role
                                    </option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">
                                            {{ $role->name }} </option>
                                    @endforeach
                                    

                                </select>


                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>




                    </div>


                    <div class="row align-items-center">

                        <div class="col-md-6 mb-3">
                            <label for="ID_no" autofocus required>ID Number</label>
                            <div class="input-group">

                                <input class="form-control datepicker-input" type="text" id="ID_no"
                                    placeholder="Enter Employee's National ID" wire:model="ID_no">
                                @error('ID_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="birth" autofocus required>Birthday</label>
                            <div class="input-group">

                                <input class="form-control datepicker-input" type="date" id="birth"
                                    wire:model="birth">
                                @error('birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="gender">Gender</label>
                            <select class="form-select mb-0" id="gender" aria-label="Gender select example"
                                wire:model="gender" autofocus required>
                                <option value=""  selected>Select Employee's gender</option>
                                <option value="Male">Male</option>

                                <option value="Female">Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

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


                    <div class="row">
                        <h2 class="h5 my-4">Salar information</h2>

                        <div class="col-md-6 mb-3">
                            <label for="salary">Salary @if($this->part_time) -  {{$this->part_time}} @endif</label>
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
                                    <option value="" selected >Select Bank</option>

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
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
                                    placeholder="Enter Employee's Email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input class="form-control" id="phone" type="number"
                                    placeholder="Enter Employee's Phone" wire:model="phone">
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
                        <div class="col-md-7 mb-3">
                            <h2 class="h5 my-4">He wants to participate in Social Security</h2>
                            <div class="form-group">
                                <label class="form-check-label" for="user-notification-1"></label>
                                <div class="form-check form-switch">
                                    <input style="width:40px" class="form-check-input" type="checkbox" id="status" wire:model="social_security" checked="false">
                                </div>
                            </div>
                        </div>
                    </div>


                    <h2 class="h5 my-4">Password</h2>
                    <div class="row">
                        <div class="col-sm-9 mb-3">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" id="password" type="password"
                                    placeholder="Enter Employee's  password" wire:model="password" autofocus required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-sm-9 mb-3">
                            <div class="form-group">
                                <label for="passwordConfirmation"> Password Confirmation</label>
                                <input class="form-control" id="passwordConfirmation" type="password"
                                    placeholder="Password Confirmation" wire:model="passwordConfirmation" autofocus
                                    required>
                                @error('passwordConfirmation')
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



            <div class="col-12 col-xl-4">
                <div class="row ">
                    <div class="col-12 mb-4">
                        <div class="align-items-center card shadow border-0 text-center p-0">

                            <div class="card-body pb-5">
                                <h4 class="h3">{{ $this->name }}</h4>
                                <h5 class="fw-normal">{{ $this->departmentName . ' - ' . $this->position }}</h5>

                            </div>

                            <div class="col-sm-10 mb-3 ">
                                <label for="formFile" class="form-label">upload Employee's image</label>
                                <input class="form-control" type="file" id="image" wire:model="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <!-- End of Form -->
                        </div>
                    </div>



                    <div class="col-12 mb-4">
                        <div class="align-items-center card shadow border-0 text-center p-0">

                            <div class="card-body pb-5">
                                <h4 class="h3">Upload conrtacts copy</h4>

                            </div>
                            <div class="col-sm-10 mb-3 ">
                                <label for="formFile" class="form-label">upload contract's copy</label>
                                <input class="form-control" type="file" id="contract" wire:model="contract">
                                @error('contract')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row flex-column">
                            <h1>Duration of the Contract</h1>
                            <label class="container">3 month
                            <input wire:model="Duration_contract" value="0"  type="radio" checked="checked"  name="Duration_contract">
                            <span class="checkmark"></span>
                            </label>
                            <label class="container">1 year
                            <input wire:model="Duration_contract" value="1" type="radio" name="Duration_contract">
                            <span class="checkmark"></span>
                            </label>
                        </div>

                            <div class="col-sm-9 mb-3">
                                <div class="form-group">
                                    <label for="sign_date">Sgined date</label>
                                    <input class="form-control" id="sign_date" type="date"
                                        placeholder="Enter Employee's home signed date" wire:model="sign_date">
                                    @error('sign_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>


                            <!-- End of Form -->
                        </div>
                    </div>











                    <div class="col-12 mb-3">
                        <div class="align-items-center card shadow border-0 text-center p-0">

                            <div class="card-body pb-5">
                                <h4 class="h3">Employee's ID card image</h4>

                            </div>
                            <div class="col-sm-10 mb-3 ">
                                <label for="formFile" class="form-label">upload Employee's ID card image</label>
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
                                <h4 class="h3">Employee's License image</h4>

                            </div>
                            <div class="col-sm-10 mb-3 ">
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


                    <div class="col-12 mb-3">
                        <div class="card card-body border-0 shadow mb-4 mb-xl-0">
                            <h2 class="h5 mb-4">Activities</h2>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                                    <div>
                                        <h3 class="h6 mb-1">Active</h3>
                                        <p class="small pe-4">Employee's Account Active</p>
                                    </div>
                                    <div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="user-notification-1"
                                                checked>
                                            <label class="form-check-label" for="user-notification-1"></label>
                                        </div>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                                    <div>
                                        <h3 class="h6 mb-1">Account Activity</h3>
                                        <p class="small pe-4">Get important notifications about you or activity you've
                                            missed</p>
                                    </div>
                                    <div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="user-notification-2">
                                            <label class="form-check-label" for="user-notification-2"></label>
                                        </div>
                                    </div>
                                </li>

                            </ul>
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
</main>