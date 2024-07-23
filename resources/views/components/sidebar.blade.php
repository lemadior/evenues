@props(['date', 'eventsLink', 'venuesLink', 'weather'])

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

            <div>
                <ul>
                    <li>Air Temp: {{ $weather['airTemperature'] }}°C</li>
                    <li>Humidity: {{ $weather['humidity'] }}%</li>
                    <li>Pressure: {{ $weather['pressure'] }}hPa</li>
                    <li>Visibility: {{ $weather['visibility'] }}km</li>
                    <li>Water Temp: {{ $weather['waterTemperature'] }}°C</li>
                    <li>Wind Speed: {{ $weather['windSpeed'] }}m/s</li>
                    <li>Wind Direction: {{ $weather['windDirection'] }}°</li>
                </ul>
            </div>
        </div>
    </nav>
</aside>
