@include('admin_dashboard_header')

@if ($errors->any())
    <br><br>
    <div id="errorAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('success'))
    <br><br>
    <div id="successAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('update_success'))
    <br><br>
    <div id="successAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('update_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->

<h1 class="mt-4" style = "text-align : center; color : #454545;">Events</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active" style = "font-weight : 500;">Add New Events</li>
                        </ol>
<form method="POST" action="{{ route('adding_event') }}">
    @csrf
    <div class="mb-3">
        <label for="service_name" class="form-label">Event Name</label>
        <input type="text" class="form-control" id="service_name" value = "{{ old('event_name') }}" name="event_name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Event

    </button>
</form>

<h1 class="mt-4" style = "text-align : center; color : #454545;">All Events</h1>

<table class="table">
    <thead>
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>


    <tbody>
        @if(isset($allEvents))
        @if(count($allEvents) > 0)
            @foreach($allEvents as $eachEvent)
                <tr>
                    <td>{{ $eachEvent->id }}</td>
                    <td>{{ $eachEvent->event_name }}</td>
                    <td>{{ $eachEvent->description }}</td>
                    <td>
                                <button class="btn btn-success edit-btn" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{$eachEvent->id}}"><i class="far fa-edit"></i></button>
                                <a class="btn btn-danger edit-btn" onclick = "return confirm('Are you sure to delete this Event !')" href = "{{ route('deleting_event', $eachEvent->id) }}"><i class="fa-solid fa-trash"></i></a>

                                <div class="modal fade" id="editModal{{$eachEvent->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$eachEvent->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{$eachEvent->id}}">Edit Event</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editForm{{$eachEvent->id}}" method = "post" action = "{{ route('updating_event', $eachEvent->id) }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="editServiceName{{$eachEvent->id}}" class="form-label">Event Name</label>
                                                        <input type="text" class="form-control" id="editServiceName{{$eachEvent->id}}" value = "{{$eachEvent->event_name}}" name="event_name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editDescription{{$eachEvent->id}}" class="form-label">Description</label>
                                                        <textarea class="form-control" id="editDescription{{$eachEvent->id}}" name="description" rows="3" required>{{$eachEvent->description}}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                        @if($eachEvent->is_active == "1")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to deactivate this Event !')" href="{{ route('deactivating_event', $eachEvent->id) }}">
                                Deactivate
                            </a>
                        @endif

                        @if($eachEvent->is_active == "0")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to activate this Event !')" href="{{ route('activating_event', $eachEvent->id) }}">
                                Activate
                            </a>
                        @endif

                    </td>
                </tr>
            @endforeach

        @else
            <tr>
                <td colspan="4" style = "text-align: center; color : #454545;"><b>No any event added yet !</b></td>
            </tr>
        @endif
        @endif

    </tbody>
</table>

               
@include('admin_dashboard_footer')
