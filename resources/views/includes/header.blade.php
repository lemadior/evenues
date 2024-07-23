<header class="header">
    <div class="header__logo">
        @if($page !== 'home')
            <a href="{{ route('main.index') }}">⊷</a>
        @else
            <span class="logo">⊷</span>
        @endif
        <p><span>Event&nbsp;Weather&nbsp;Hub</span></p>
    </div>
    <nav class="header__menu">
        <ul>
            @auth
                <li>
                    <form action="{{ route('auth.logout') }}" method="post">
                        @csrf

                        <input type="submit" value="Logout"/>
                    </form>
                </li>
            @endauth
        </ul>
    </nav>
</header>
