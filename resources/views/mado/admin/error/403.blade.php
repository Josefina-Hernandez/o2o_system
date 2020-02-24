<p>
    403エラー<br>
    {{ $exception->getMessage() }}
</p>

<p>
    {{-- ログアウトボタン --}}
    <a href="{{ route('admin.shop.logout') }}"
        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
        Logout
    </a>

    <form id="logout-form" action="{{ route('admin.shop.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    {{-- userid --}}
    @if (Auth::check())
        userid: {{ Auth::id() }}
    @endif
</p>