<title>Dashboard</title>
<div class="py-4">
    <h2 style="background-color: #aeb3cc;padding:1rem">Employees List Active</h2>
    <div style="overflow: auto;max-height:300px" class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">ID</th>
                    <th class="border-gray-200">Name</th>
                    <th class="border-gray-200">Company</th>
                    <th class="border-gray-200">Position</th>
                    <th class="border-gray-200">expire contract</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeUser as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->company }}</td>
                        <td>{{ $item->position }}</td>
                        <td>{{ $item->expire_contract ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <h2 style="background-color: #aeb3cc;padding:1rem;margin:1rem">Attendance List</h2>
    <div style="overflow: auto;max-height:300px" class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">ID</th>
                    <th class="border-gray-200">Name</th>
                    <th class="border-gray-200">Company</th>
                    <th class="border-gray-200">Position</th>
                    <th class="border-gray-200">Check In</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->company }}</td>
                        <td>{{ $item->position }}</td>
                        <td>{{ $item->check_in }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
