<h3>Recent Blog Posts</h3>
<ul class="list-group">
    @if($posts->isEmpty())
        <li class="list-group-item">
            <h4>There are no blog posts.</h4>
        </li>
    @else
        @foreach($posts as $post)
            <li class="list-group-item">
                <h4>
                    <a href="{{ route('frontend.blog.detail', $post->id) }}">{{ $post->title }}</a>
                    <a href="{{ route('blog.edit', $post->id) }}" class="pull-right"><span
                                class="glyphicon glyphicon-edit"></span></a>
                </h4>

                {!! $post->shortExcerptHtml() !!}
            </li>
        @endforeach
    @endif
</ul>