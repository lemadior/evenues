<footer class="footer">
    <div class="footer__left">
        <p>© 2024. All rights reserved</p>
    </div>

    @auth
        <div class="footer__middle">
            <a href="{{ route('admin.index') }}">Event and Weather Management Platform!</a>
        </div>
    @else
        <div class="footer__middle">
            <a href="{{ route('auth.login') }}">Login</a>
            <a href="{{ route('auth.register') }}">Register</a>
        </div>
    @endauth


    <div class="footer__right">
        <p>Event Weather Hub</p>
    </div>
</footer>
