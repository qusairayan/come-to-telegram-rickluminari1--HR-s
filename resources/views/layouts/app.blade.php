<x-layouts.base>
    @if (in_array(request()->route()->getName(), [
            'dashboard.index',
            'profile.index',
            'employees.index',
            'employees.edit',
            'employees.view',
            'employees.create',
            'promotions.create',
            'promotions.edit',
            'promotions.view',
            'promotions.index',
            'banks.index',
            'employees.lateness',
            'employees.overtime',
            'attendences',
            'leaves',
            'vacations',
            'schedule',
            'schedule.set',
            'deductions',
            'allownces',
            'payrolls.salaries',
            'payrolls.addSalary',
            'permissions',
            'permissions.edit',
            'permissions.roles',
            'permissions.role.edit',
            'roles',
            'role.addNew',
            'profile-example',
            'departments',
            'users',
            'bootstrap-tables',
            'transactions',
            'buttons',
            'forms',
            'modals',
            'notifications',
            'typography',
            'upgrade-to-pro',
            'payrolls.socialsecurity',
            'payrolls.slips',
            'payrolls.newSalary',
            'payrolls.part_time',
            'payrolls.add_part_time',
            'payrolls.edit_part_time',
            'payrolls.view_part_time',
            'payrolls.depositsalary',
            'attendence.Report.pdf',
            'payrolls.depositSalarypdf',
            'attendence.Report',
            'employee.VacationBalance',
            'vacations.report',
            'locations',
        ]))
        {{-- Nav --}}
        @include('layouts.nav')
        {{-- SideNav --}}
        @include('layouts.sidenav')
        <main class="content">
            {{-- TopBar --}}
            @include('layouts.topbar')
            {{ $slot }}
            {{-- Footer --}}
            {{-- @include('layouts.footer') --}}
        </main>
    @elseif(in_array(request()->route()->getName(), [
            'register',
            'register-example',
            'login',
            'login-example',
            'forgot-password',
            'forgot-password-example',
            'reset-password',
            'reset-password-example',
        ]))
        {{ $slot }}
        {{-- Footer --}}
        @include('layouts.footer2')
    @elseif(in_array(request()->route()->getName(), ['404', '500', 'lock']))
        {{ $slot }}
    @endif
</x-layouts.base>
