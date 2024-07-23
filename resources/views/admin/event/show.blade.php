@php($page = 'show')
@php($date = explode(' ', $event->event_date)[0])
@extends('layouts.main')

@section('title', 'Event: Admin Dashboard: Show')

@section('content')

    <div class="dashboard">
        <x-sidebar eventsLink="admin.events" venuesLink="admin.venues" :date="$date"/>
        <main class="main">
            <div class="container">
                <nav class="breadcrumbs">
                    <a href="{{ route('admin.index') }}">Main</a>
                    <span>&gt;</span>
                    <a href="{{ route('admin.events') }}">Events</a>
                    <span>&gt;</span>
                    <span>Event</span>
                </nav>


                <div class="page__heading">
                    <h5>Event: <span><em>{{ $event->name }}</em></span></h5>
                </div>

                <div class="page__text flex_row">
                    <div class="poster">
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="Event image"/>
                    </div>
                    <div class="entity__data flex-column">
                        <p>
                            Date: {{ $event->event_date }}
                        </p>

                        <p>
                            Venue: {{ $event->venue->name }}
                        </p>

                        @auth
                            <div class="buttons">
                                <a href="{{ route('admin.edit.event', $event->id) }}" class="button">EDIT</a>

                                <form action="{{ route('admin.delete.event', $event->id) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button type="submit"
                                            onclick="return confirm('Are You sure to delete this student\'s record?')"
                                            class="button">DELETE
                                    </button>
                                </form>

                            </div>
                        @endauth
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection
