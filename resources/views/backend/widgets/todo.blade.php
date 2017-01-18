<h3>ToDo</h3>
<ul class="list-group">
    @if($tasks->isEmpty())
        <li class="list-group-item">
            <h4>There are no tasks.</h4>
        </li>
    @else
        @foreach($tasks as $task)
            <li class="list-group-item">
                <h4>
                    <a href="{{ route('todo.detail', $task->id) }}">{{ $task->title }}</a>

                    <div class="taskFinished">
                        <a href="{{ route('todo.finishedTask', $task->id) }}"><span
                                    class="glyphicon glyphicon-ok"></span></a>
                        <a href="{{ route('todo.edit', $task->id) }}"><span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                </h4>

                {!! $task->descriptionHtml() !!}
            </li>
        @endforeach
    @endif
</ul>