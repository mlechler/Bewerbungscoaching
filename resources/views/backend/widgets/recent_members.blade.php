<h3>Recent Members</h3>
<ul class="list-group">
    @if($members->isEmpty())
        <li class="list-group-item">
            <h4>There is no member logged in.</h4>
        </li>
    @else
        @foreach($members as $member)
            <li class="list-group-item">
                <h4>{{ $member->getName() }}</h4>

                Last Login {{ $member->lastLoginDifference() }}
            </li>
        @endforeach
    @endif
</ul>