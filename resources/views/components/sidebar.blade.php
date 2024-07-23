@props(['date', 'eventsLink', 'venuesLink'])

<aside>
    <h4>Dashboard</h4>
    <nav>
        <ul>
            <li class="{{ Route::currentRouteName() === $eventsLink ? 'inactive' : '' }}"><a
                    href="{{ route($eventsLink) }}">Events</a></li>
            <li class="{{ Route::currentRouteName() === $venuesLink ? 'inactive' : '' }}"><a
                    href="{{ route($venuesLink) }}">Venues</a></li>
        </ul>
        <hr/>
        <div class="weather">
            <h5>Weather</h5>
            <span>{{ $date }}</span>
        </div>
    </nav>
</aside>
