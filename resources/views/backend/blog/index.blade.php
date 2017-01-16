@extends('layouts.backend')

@section('title', 'Blog Posts')

@section('content')
    <a href="{{ route('blog.create') }}" class="btn btn-primary">Create New Post</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Title or Author']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="postTable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Author</th>
            <th>Published</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($posts->isEmpty())
            <tr>
                <td colspan="7" align="center">There are no blog posts.</td>
            </tr>
        @else
            @foreach($posts as $post)
                <tr class="{{ $post->publishedHighlight() }}">
                    <td>
                        {{ $post->title }}
                    </td>
                    <td>
                        {{ $post->slug }}
                    </td>
                    <td>
                        {{ $post->getName() }}
                    </td>
                    <td>
                        {{ $post->publishedDate() }}
                    </td>
                    <td>
                        <a href="/backend/blog/<?php echo $post->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="/backend/blog/<?php echo $post->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/blog/<?php echo $post->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $posts->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("postTable");
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