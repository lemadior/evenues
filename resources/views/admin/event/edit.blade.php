@php($page = 'create')
@php($date = explode(' ', $event->event_date)[0])
@extends('layouts.main')
@section('title', 'Event: Admin Dashboard: Edit')
@section('content')
    <div class="dashboard">
        <x-sidebar eventsLink="admin.events" venuesLink="admin.venues" :date="$date" :weather="$weather"/>
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
                    <h5>Dashboard: Edit the Event</h5>
                </div>

                <div class="page__text flex_row">
                    <div class="entity__data flex-column">
                        <form name='groups_form' action="{{ route('admin.update.event', $event->id) }}" method='post'
                              enctype="multipart/form-data" class="student__form">
                            @csrf
                            @method('patch')

                            <label for="name" class="label__event">Event name:</label>
                            <input type='text' name='name' placeholder="Event Name"
                                   value="{{ old('name') ?? $event->name }}"/>
                            <x-error error='name'/>

                            <label for="event_date" class="label__event">Event date:</label>
                            <input type="date" id="event_date" name="event_date"
                                   value="{{ old('event_date') ?? explode(' ', $event->event_date)[0] }}"
                                   min="2017-01-01" max="2024-12-31"/>
                            <x-error error='event_date'/>

                            <div class="thumbnail">
                                <p class="label__event poster__edit_label">Current poster image</p>
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="Current poster image"
                                     class="poster poster_thumbnail">
                            </div>

                            <label for="poster" class="label__event">Choose a new poster picture:</label>
                            <input type="file" id="poster" name="poster" accept="image/png, image/jpeg"/>
                            <x-error error='poster'/>

                            <div class="add_venue">
                                <p>Select Venue</p>
                                <select name='venue_id'>
                                    @foreach($venues as $venue)
                                        <option
                                            value="{{ old('venue_id') ?? $venue->id }}" @selected($event->venue_id == $venue->id)>{{ $venue->name }}</option>
                                    @endforeach
                                </select>

                                <p class="note"><em><strong>Note:</strong> assigned venue cannot be changed
                                        afterwards</em></p>
                            </div>

                            <input type='submit' value='Apply' class="button button_apply"/>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection
