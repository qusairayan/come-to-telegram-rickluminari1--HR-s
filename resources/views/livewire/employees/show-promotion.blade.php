<div>
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
                            <select class="form-select mb-0" disabled id="user" aria-label="user select example"
                                autofocus>
                                <option selected>{{ $promotion->name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="name">Company</label>
                        <select class="form-select mb-0" id="company" aria-label="company select example" autofocus
                            disabled>
                            <option value="{{ $promotion->company }}" selected>{{ $promotion->company }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="position">Position</label>
                        <div class="input-group">
                            <select class="form-select mb-0" id="position" disabled
                                aria-label="position select example" autofocus="" required="">
                                <option value="{{ $promotion->position }}">{{ $promotion->position }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="department">Department</label>
                        <select class="form-select mb-0" id="department" disabled aria-label="department select example"
                            autofocus="">
                            <option selected value="{{ $promotion->id }}">
                                {{ $promotion->department }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="position">Employee Type</label>
                        <div class="input-group">
                            <select class="form-select mb-0" id="type" aria-label="type select example"
                                autofocus="" required="" disabled>
                                @if ($promotion->type == 1)
                                    <option value="full-time">Full-time</option>
                                @else
                                    <option value="part-time">Part-time</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    @if ($promotion->type == 0)
                        <div class="col-md-4 mb-3">
                            <label for="position">Part Time Period</label>
                            <div class="input-group">
                                <select disabled class="form-select mb-0" id="part_time"
                                    aria-label="part_time select example" autofocus required>
                                    <option value="{{ $promotion->part_time }}" selected>{{ $promotion->part_time }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4 mb-3">
                        <label for="salary">Salary</label>
                        <div class="input-group">
                            <input class="form-control datepicker-input" type="text" id="salary"
                                value="{{ $promotion->salary }}" disabled autofocus>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="start_date">Satrt Date</label>
                        <div class="input-group">
                            <input class="form-control datepicker-input" type="date" id="from" disabled
                                autofocus value="{{ $promotion->from }}">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="start_date">End Date</label>
                        <div class="input-group">
                            <input disabled class="form-control datepicker-input" type="date" id="from"
                                autofocus value="{{ $promotion->to }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
