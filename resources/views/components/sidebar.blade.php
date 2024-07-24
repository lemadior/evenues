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
            <h5>Date</h5>
            <span>{{ $date }}</span>

            <div class="location">
                <h5>Location:</h5>
                @if(!empty($weather['location']))
                <span><strong>{{ $weather['location'] }}</strong></span>
                @endif
            </div>

            <div class="ip">
                <h5>IP address:</h5>
                @if(!empty($weather['ip']))
                <span><strong>{{ $weather['ip'] }}</strong></span>
                @endif
            </div>

            <div class="weather__data">
                <h5>Weather</h5>
                <ul class="weather__list">
                    @if(!empty($weather['airTemperature']))
                    <li class="weather__item"><span class="weather__item_label">Air Temp:</span> <span class="weather__item_data">{{ $weather['airTemperature'] }}°C</span></li><li class="weather__item"><span class="weather__item_label">Humidity:</span> <span class="weather__item_data">{{ $weather['humidity'] }}%</span></li>
                    @endif
                    @if(!empty($weather['pressure']))
                    <li class="weather__item"><span class="weather__item_label">Pressure:</span> <span class="weather__item_data">{{ $weather['pressure'] }} hPa</span></li>
                    @endif
                    @if(!empty($weather['visibility']))
                    <li class="weather__item"><span class="weather__item_label">Visibility:</span> <span class="weather__item_data">{{ $weather['visibility'] }} km</span></li>
                    @endif
                    @if(!empty($weather['waterTemperature']))
                    <li class="weather__item"><span class="weather__item_label">Water Temp:</span> <span class="weather__item_data">{{ $weather['waterTemperature'] }}°C</span></li>
                    @endif
                    @if(!empty($weather['windSpeed']))
                    <li class="weather__item"><span class="weather__item_label">Wind Speed:</span> <span class="weather__item_data">{{ $weather['windSpeed'] }} m/s</span></li>
                    @endif
                    @if(!empty($weather['windDirection']))
                    <li class="weather__item"><span class="weather__item_label">Wind Direction:</span> <span class="weather__item_data">{{ $weather['windDirection'] }}°</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</aside>
