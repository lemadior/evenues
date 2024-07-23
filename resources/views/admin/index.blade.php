@php($page = 'admin')
@extends('layouts.main')
@section('title', 'EventWeatherHub: Admin Dashboard')
@section('content')
    <div class="dashboard">
        <x-sidebar eventsLink="admin.events" venuesLink="admin.venues" :date="$currentDate"/>

        <main class="main">
            <div class="container">
                <nav class="breadcrumbs">
                    <span href="">Main</span>
                </nav>

                <div class="page__text">
                    <h4>Welcome to the Main Content Area</h4>

                    <p>
                        Here, you can view, edit, and delete Events and Venues with ease by using the Sidebar. This
                        page also displays the current weather conditions for your location, ensuring you stay
                        informed while managing your events.
                    </p>
                </div>
            </div>
        </main>
    </div>
@endsection
