<ul class="list-group">
    @foreach($employees as $employee)
        <li class="list-group-item">
            <h4>{{ $employee->getName() }}</h4>

            {{ $employee->last_login_at }}}
        </li>
    @endforeach
</ul>