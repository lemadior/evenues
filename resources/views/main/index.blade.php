@php($page = 'home')

@extends('layouts.main')

@section('content')
    <main class="main">
        <h1 class="text-center">Ultimate Event and Weather Management Platform!</h1>

        <section>
            <div class="container ">

                <div class="col-8 intro">
                    <p>
                        Experience the perfect blend of event planning and real-time weather updates with Event Weather
                        Hub.
                        Our platform is designed to provide administrators with seamless control over events and venues,
                        ensuring every detail is perfectly managed. With Event Weather Hub, you can easily create,
                        update,
                        and delete events while associating them with specific venues, making event management a breeze.
                    </p>

                    <p>
                        Imagine planning an event and instantly knowing the weather forecast for the chosen venue and
                        date.
                        EventWeatherHub makes this possible by integrating advanced weather service APIs, providing you
                        with
                        up-to-date weather conditions for each event. This invaluable feature helps you plan better,
                        prepare
                        for any weather conditions, and ensure your events run smoothly.
                    </p>

                    <p>
                        Our user-friendly interface allows administrators to access a comprehensive list of events and
                        perform
                        basic CRUD operations with ease. Whether you need to add a new event, edit details, or remove an
                        outdated
                        listing, Event Weather Hub offers the tools you need to stay organized and efficient.
                    </p>

                    <p>
                        But that's not all. If you haven’t selected an event, our platform will display the current
                        weather
                        conditions based on your location. By using your IP address, EventWeatherHub provides accurate
                        and
                        immediate weather updates, keeping you informed and prepared at all times.
                    </p>

                    <p>
                        Event Weather Hub is your go-to solution for integrated event management and weather tracking.
                        Say
                        goodbye to the hassle of juggling multiple tools and embrace the convenience of having
                        everything
                        you need in one place. Perfect for administrators looking for a robust and intuitive platform to
                        manage events and stay ahead of the weather.
                    </p>

                    <p>
                        Join Event Weather Hub today and transform the way you manage events and weather updates. Stay
                        organized, stay informed, and make every event a success with Event Weather Hub!
                    </p>
                </div>

            </div>
        </section>


        <section>
            @guest
                <div class="container ">
                    <div>
                        <a href="{{ route('auth.login') }}" class="col-6 btn btn-success">Start use service</a>
                    </div>
                </div>
            @endguest
        </section>

    </main>
@endsection
