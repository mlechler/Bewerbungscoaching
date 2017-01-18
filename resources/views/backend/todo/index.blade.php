@extends('layouts.backend')

@section('title', 'Tasks')

@section('content')
    <a href="{{ route('todo.create') }}" class="btn btn-primary">Create New Task</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Title or Creator']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="taskTable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Creator</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($tasks->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no tasks.</td>
            </tr>
        @else
            @foreach($tasks as $task)
                <tr class="{{ $task->finishedHighlight() }}">
                    <td>
                        {{ $task->title }}
                    </td>
                    <td>
                        {!! $task->getShortDescription() !!}
                    </td>
                    <td>
                        {{ $task->getName() }}
                    </td>
                    <td>
                        <a href="{{ route('todo.detail', $task->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('todo.edit', $task->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('todo.confirm', $task->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $tasks->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("taskTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        td = tr[i].getElementsByTagName("td")[2];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            }
        }
    </script>
@endsection