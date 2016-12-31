<ul class="list-group">
    @foreach($posts as $post)
        <li class="list-group-item">
            <h4>
                <a href="#">{{ $post->title }}</a>
                <a href="{{ route('blog.edit', $post->id) }}" class="pull-right"><span class="glyphicon glyphicon-edit"></span></a>
            </h4>

            {!! $post->excerptHtml() !!}
        </li>
    @endforeach
</ul>