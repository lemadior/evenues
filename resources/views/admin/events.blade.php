@php($page = 'admin')
@extends('layouts.main')
@section('title', 'Events: Admin Dashboard')
@section('content')
    <div class="dashboard">
        <x-sidebar eventsLink="admin.events" venuesLink="admin.venues" :date="$eventsData['currentDate']"/>
        <main class="main">
            <div class="container">
                <nav class="breadcrumbs">
                    <a href="{{ route('admin.index') }}">Main</a>
                    <span>&gt;</span>
                    <span>Events</span>
                </nav>

                <div class="page__text">
                    <h4>Available Events: Full List</h4>
                </div>
                <div class="page__text">
                    <a href="{{ route('admin.create.event') }}"><input type='button' value='Add event'
                                                                       class="button admin_button_add"/></a>

                    <div class="per_page">
                        <label for="per_page">Count per Page</label>
                        <select name="per_page" id="per_page">
                            <option value="5" @selected($eventsData['perPage'] == 5)>5</option>
                            <option value="10" @selected($eventsData['perPage'] == 10)>10</option>
                            <option value="15" @selected($eventsData['perPage'] == 15)>15</option>
                            <option value="20" @selected($eventsData['perPage'] == 20)>20</option>
                        </select>

                    </div>
                    <table class="mytable">
                        <thead>
                        <tr>
                            <th id="events_id"
                                class="{{ $eventsData['sorting'] === 'id' ? $eventsData['direction'] : '' }}">ID
                            </th>
                            <th id="events_name"
                                class="{{ $eventsData['sorting'] === 'name' ? $eventsData['direction'] : '' }}">Event
                                Name
                            </th>
                            <th>Poster</th>
                            <th id="events_date"
                                class="{{ $eventsData['sorting'] === 'event_date' ? $eventsData['direction'] : '' }}">
                                Date
                            </th>
                            <th id="events_venue"
                                class="{{ $eventsData['sorting'] === 'venue' ? $eventsData['direction'] : '' }}">Venue
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @isset($eventsData['events'])
                            @foreach($eventsData['events'] as $event)
                                <tr>
                                    <td>{{ $event->id }}</td>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ basename($event->poster) }}</td>
                                    <td>
                                        <p>{{ explode(' ', $event->event_date)[0] }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $event->venue->name }}</p>
                                    </td>
                                    <td>
                                        <div class="table__action">

                                            <a href="{{ route('admin.show.event', $event->id) }}"
                                               class="table__action_view">👁</a>

                                            <a href="{{ route('admin.edit.event', $event->id) }}"
                                               class="table__action_edit">✎</a>

                                            <form action="{{ route('admin.delete.event', $event->id) }}" method="post">
                                                @csrf
                                                @method('delete')

                                                <button type="submit"
                                                        onclick="return confirm('Are You sure to delete this student\'s record?')"
                                                        class="table__action_delete">✖
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                        </tbody>
                    </table>

                    @isset($eventsData['events'])
                        <div class="paginate_space">
                            @if($eventsData['sorting'])
                                {{ $eventsData['events']
                                    ->appends(['per_page' => $eventsData['perPage'], 'sorting' => $eventsData['sorting'], 'direction' => $eventsData['direction']])
                                    ->links() }}
                            @else
                                {{  $eventsData['events']->appends(['per_page' => $eventsData['perPage']])->links() }}
                            @endif
                        </div>
                    @endisset
                </div>
            </div>

        </main>
    </div>>

    <script src="{{ asset('assets/js/paginate.js') }}"></script>
    <script src="{{ asset('assets/js/sorting.js') }}"></script>
@endsection
