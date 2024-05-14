<div class="public_banks">
    <title>Bank </title>
    <div class="title">
        <h1>Banks</h1>
    </div>
    <div class="create-bank row m-5">
        <div class="col-md-6 col-12">
            <input class="form-control" type="text" wire:model="bankName" name="bankName" id="bankName"
                placeholder="Enter Bank Name">
            @error('bankName')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 col-12">
            <button class="btn btn-primary w-100" wire:click="create">Create New</button>
        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>

                <th class="border-gray-200">ID</th>
                <th class="border-gray-200">Bank</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banks as $item)
                <tr>
                    <td class="border-0 fw-bold"><span class="fw-normal">{{ $item->id }}</span></td>
                    <td class="border-0 fw-bold"><span class="fw-normal">{{ $item->name }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
