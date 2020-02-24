@if (Breadcrumbs::has(\Route::currentRouteName()))
    <ul class="topicPath">
        @foreach (Breadcrumbs::get(\Route::currentRouteName()) as $page)
            <li>
                @if (! $loop->last)
                    <a href="{{ $page['url'] }}">{{ $page['title'] }}</a>
                @else
                    {{ $page['title'] }}
                @endif
            </li>
        @endforeach
    </ul>
@endif
