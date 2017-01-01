<h3>Recent Employees</h3>
<ul class="list-group">
    @foreach($employees as $employee)
        <li class="list-group-item">
            <h4>{{ $employee->getName() }}</h4>

            Last Login {{ $employee->lastLoginDifference() }}
        </li>
    @endforeach
</ul>