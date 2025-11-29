@extends('layouts.app')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">My Calendar</h1>
        <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Event
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div id="calendar" class="w-full"></div>
    </div>
</div>

<!-- Create/Edit Event Modal -->
<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-800">Add New Event</h3>
        </div>
        <form id="eventForm" class="p-6">
            @csrf
            <input type="hidden" id="eventId" name="id">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" id="title" name="title" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="datetime-local" id="start_time" name="start_time" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="datetime-local" id="end_time" name="end_time" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <div class="flex space-x-2">
                        <div class="color-option">
                            <input type="radio" name="color" value="#3b82f6" id="color-blue" class="hidden" checked>
                            <label for="color-blue" class="w-8 h-8 bg-blue-500 rounded-full cursor-pointer block"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="color" value="#ef4444" id="color-red" class="hidden">
                            <label for="color-red" class="w-8 h-8 bg-red-500 rounded-full cursor-pointer block"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="color" value="#10b981" id="color-green" class="hidden">
                            <label for="color-green" class="w-8 h-8 bg-green-500 rounded-full cursor-pointer block"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="color" value="#f59e0b" id="color-yellow" class="hidden">
                            <label for="color-yellow" class="w-8 h-8 bg-yellow-500 rounded-full cursor-pointer block"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="color" value="#8b5cf6" id="color-purple" class="hidden">
                            <label for="color-purple" class="w-8 h-8 bg-purple-500 rounded-full cursor-pointer block"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition duration-200">
                    Save Event
                </button>
                <button type="button" id="deleteButton" onclick="deleteEvent()" 
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition duration-200 hidden">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '{{ route("events.get") }}',
        editable: true,
        selectable: true,
        select: function(info) {
            openCreateModal();
            document.getElementById('start_time').value = info.startStr.substring(0, 16);
            document.getElementById('end_time').value = info.endStr.substring(0, 16);
        },
        eventClick: function(info) {
            openEditModal(info.event);
        },
        eventDrop: function(info) {
            updateEvent(info.event);
        },
        eventResize: function(info) {
            updateEvent(info.event);
        }
    });

    calendar.render();
    window.calendar = calendar;
});

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Add New Event';
    document.getElementById('eventForm').reset();
    document.getElementById('eventId').value = '';
    document.getElementById('deleteButton').classList.add('hidden');
    document.getElementById('eventModal').classList.remove('hidden');
}

function openEditModal(event) {
    document.getElementById('modalTitle').textContent = 'Edit Event';
    document.getElementById('eventId').value = event.id;
    document.getElementById('title').value = event.title;
    document.getElementById('description').value = event.extendedProps.description || '';
    document.getElementById('start_time').value = event.startStr.substring(0, 16);
    document.getElementById('end_time').value = event.endStr.substring(0, 16);
    
    // Set color
    const color = event.backgroundColor || '#3b82f6';
    document.querySelector(`input[name="color"][value="${color}"]`).checked = true;
    
    document.getElementById('deleteButton').classList.remove('hidden');
    document.getElementById('eventModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

function deleteEvent() {
    const eventId = document.getElementById('eventId').value;
    
    if (confirm('Are you sure you want to delete this event?')) {
        fetch(`/events/${eventId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.calendar.refetchEvents();
                closeModal();
            }
        });
    }
}

document.getElementById('eventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const eventId = document.getElementById('eventId').value;
    const url = eventId ? `/events/${eventId}` : '/events';
    const method = eventId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.calendar.refetchEvents();
            closeModal();
        } else {
            alert('Error: ' + JSON.stringify(data.errors));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the event.');
    });
});

function updateEvent(event) {
    const eventData = {
        title: event.title,
        description: event.extendedProps.description || '',
        start_time: event.start.toISOString().substring(0, 16),
        end_time: event.end ? event.end.toISOString().substring(0, 16) : event.start.toISOString().substring(0, 16),
        color: event.backgroundColor
    };
    
    fetch(`/events/${event.id}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventData)
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Error updating event:', data.errors);
            event.revert();
        }
    });
}
</script>

<style>
.color-option input:checked + label {
    border: 3px solid #1e40af;
    transform: scale(1.1);
}
.fc-event {
    cursor: pointer;
}
.fc-day-today {
    background-color: #eff6ff !important;
}
</style>
@endpush