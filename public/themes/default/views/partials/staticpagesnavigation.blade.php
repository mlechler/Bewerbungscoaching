@foreach($pages as $page)
    <li class="{{ Request::is($page->uriWildcard()) ? 'active' : '' }} {{ count($page->children) ? ($page->isChild() ? 'dropdown-submenu' : 'dropdown') : '' }}">
        <a href="{{ url($page->uri) }}">
            {{ $page->title }}

            @if(count($page->children))
                @if(!$page->isChild())
                    <span class="caret"></span>
                @endif
            @endif
        </a>

        @if(count($page->children))
            <ul class="dropdown-menu">
                @include('partials.staticpagesnavigation', ['pages' => $page->children])
            </ul>
        @endif
    </li>
@endforeach