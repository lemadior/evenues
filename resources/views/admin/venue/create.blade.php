@php($page = 'create')
@extends('layouts.main')
@section('title', 'Venue: Admin Dashboard: Create')
@section('content')
    <div class="dashboard">
        <x-sidebar eventsLink="admin.events" venuesLink="admin.venues" :date="$currentDate" :weather="$weather"/>
        <main class="main">
            <div class="container">
                <nav class="breadcrumbs">
                    <a href="{{ route('admin.index') }}">Main</a>
                    <span>&gt;</span>
                    <a href="{{ route('admin.venues') }}">Venues</a>
                    <span>&gt;</span>
                    <span>Venue</span>
                </nav>

                <div class="page__heading">
                    <h5>Dashboard: Add New Venue</h5>
                </div>

                <div class="page__text flex_row">
                    <div class="entity__data flex-column">
                        <form name='groups_form' action="{{ route('admin.venues.post') }}" method='post'
                              class="student__form">
                            @csrf

                            <input type='text' name='name' placeholder="Venue Name" value="{{ old('name') }}"/>
                            <x-error error='name'/>

                            <input type='submit' value='Apply' class="button button_apply"/>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection
