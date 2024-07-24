@php($page = 'admin')
@extends('layouts.main')
@section('title', 'Venues: Admin Dashboard')
@section('content')
    <div class="dashboard">
        <x-sidebar eventsLink="admin.events" venuesLink="admin.venues" :date="$venuesData['currentDate']" :weather="$weather"/>
        <main class="main">
            <div class="container">
                <nav class="breadcrumbs">
                    <a href="{{ route('admin.index') }}">Main</a>
                    <span>&gt;</span>
                    <span>Venues</span>
                </nav>

                <div class="page__text">
                    <h4>Available Venues: Full List</h4>
                </div>
                <div class="page__text">
                    <a href="{{ route('admin.create.venue') }}"><input type='button' value='Add venue'
                                                                       class="button admin_button_add"/></a>

                    <div class="per_page">
                        <label for="per_page">Count per Page</label>
                        <select name="per_page" id="per_page">
                            <option value="5" @selected($venuesData['perPage'] == 5)>5</option>
                            <option value="10" @selected($venuesData['perPage'] == 10)>10</option>
                            <option value="15" @selected($venuesData['perPage'] == 15)>15</option>
                            <option value="20" @selected($venuesData['perPage'] == 20)>20</option>
                        </select>
                    </div>

                    <table class="mytable">
                        <thead>
                        <tr>
                            <th id="venues_id"
                                class="{{ $venuesData['sorting'] === 'id' ? $venuesData['direction'] : '' }}">ID
                            </th>
                            <th id="venues_name"
                                class="{{ $venuesData['sorting'] === 'name' ? $venuesData['direction'] : '' }}">Venue
                                Name
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @isset($venuesData['venues'])
                            @foreach($venuesData['venues'] as $venue)
                                <tr>
                                    <td>{{ $venue->id }}</td>
                                    <td>{{ $venue->name }}</td>
                                    <td>
                                        <div class="table__action">
                                            <a href="{{ route('admin.edit.venue', $venue->id) }}"
                                               class="table__action_edit">✎</a>

                                            <form action="{{ route('admin.delete.venue', $venue->id) }}" method="post">
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

                    @isset($venuesData['venues'])
                        <div class="paginate_space">
                            @if($venuesData['sorting'])
                                {{ $venuesData['venues']
                                    ->appends(['per_page' => $venuesData['perPage'], 'sorting' => $venuesData['sorting'], 'direction' => $venuesData['direction']])
                                    ->links() }}
                            @else
                                {{  $venuesData['venues']->appends(['per_page' => $venuesData['perPage']])->links() }}
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
