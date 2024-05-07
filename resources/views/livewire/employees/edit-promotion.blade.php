<div>
    <form wire:submit.prevent="create" action="#" method="POST">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <h1>Edit Promotion</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">General information</h2>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div>
                                <label for="user">Employee</label>
                                <select class="form-select mb-0" disabled id="user"
                                    aria-label="user select example" autofocus>
                                    <option selected>{{ $promotion->user_name }}</option>
                                </select>
                                @error('user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="position">Position</label>
                            <div class="input-group">
                                <input class="form-control " type="text" id="position"
                                    placeholder="Enter Employee's position" wire:model="position" autofocus
                                    value="{{ $promotion->position }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="salary">Salary</label>
                            <div class="input-group">
                                <input class="form-control datepicker-input" type="text" id="salary"
                                    placeholder="Enter Employee's salary" wire:model="salary" autofocus
                                    value="{{ $promotion->salary }}">
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="start_date">Start Date</label>
                            <div class="input-group">
                                <input class="form-control datepicker-input" type="date" id="from"
                                    placeholder="Enter Employee's start_date" wire:model="from" autofocus
                                    value="{{ $promotion->from }}">
                                @error('from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @if ($promotion->to)
                            <div class="col-md-5 mb-3">
                                <label for="start_date">Start Date</label>
                                <div class="input-group">
                                    <input class="form-control datepicker-input" type="date" id="to"
                                        placeholder="Enter Employee's start_date" wire:model="to" autofocus
                                        value="{{ $promotion->to }}">
                                    @error('to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif
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
