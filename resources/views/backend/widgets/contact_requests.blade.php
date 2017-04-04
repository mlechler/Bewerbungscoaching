<h3>Contact Requests</h3>
<ul class="list-group">
    @if($requests->isEmpty())
        <li class="list-group-item">
            <h4>There are no contact requests.</h4>
        </li>
    @else
        @foreach($requests as $request)
            <li class="list-group-item">
                <h4>
                    <a href="{{ route('contact.detail', $request->id) }}">{{ $request->name }}
                        , {{ $request->email }}</a>

                    <div class="taskFinished">
                        <a href="{{ route('contact.processRequest', $request->id) }}"><span class="glyphicon glyphicon-repeat"></span></a>
                        <a href="{{ route('contact.finishedRequest', $request->id) }}"><span
                                    class="glyphicon glyphicon-ok"></span></a>
                    </div>
                </h4>
                {{ $request->message }}
            </li>
        @endforeach
    @endif
</ul>