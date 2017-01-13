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
                    <a href="/backend/todo/<?php echo $task->id ?>/detail">{{ $task->title }}</a>

                    <div class="taskFinished">
                        <a href="/backend/todo/<?php echo $task->id ?>/finished"><span class="glyphicon glyphicon-ok"></span></a>
                    </div>
                </h4>

                {!! $task->descriptionHtml() !!}
            </li>
        @endforeach
    @endif
</ul>