/**
 * Proceed sorting on /admin/{events|venues} page
 * when user clicked on appropriate table header
 */

const sorter = {
    'events_id': 'id',
    'events_name': 'name',
    'events_date': 'event_date',
    'events_venue': 'venue',
    'venues_id': 'id',
    'venues_name': 'name'
}

const eventsId = document.getElementById('events_id');
const eventsName = document.getElementById('events_name');
const eventsDate = document.getElementById('events_date');
const eventsVenue = document.getElementById('events_venue');
const venuesId = document.getElementById('venues_id');
const venuesName = document.getElementById('venues_name');

const sorters = [eventsId, eventsName, eventsDate, eventsVenue, venuesId, venuesName];

const eventsUrl = 'http://localhost:5000/admin/events';

function isAsc(nodeId) {
    return nodeId.classList.contains('asc');
}

function isDesc(nodeId) {
    return nodeId.classList.contains('desc');
}

function setEvents(elem) {
    if (!elem) {
        return
    }

    elem.addEventListener('click', function () {
        const sortingParam = sorter[elem.id];
        const url = new URL(window.location.href);
        const sorting = {
            direction: ''
        }

        if (isAsc(elem)) {
            sorting.direction = 'desc';
        } else if (isDesc(elem)) {
            sorting.direction = '';
        } else {
            sorting.direction = 'asc';
        }

        const isSorting = !!sorting.direction;

        if (isSorting) {
            url.searchParams.set('sorting', sortingParam);
            url.searchParams.set('direction', sorting.direction);
        } else {
            url.searchParams.delete('sorting');
            url.searchParams.delete('direction');
        }

        window.location.href = url.toString();
    });
}

sorters.forEach(sorter => setEvents(sorter));
