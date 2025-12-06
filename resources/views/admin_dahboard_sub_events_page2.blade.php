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

<h1 class="mt-4" style = "text-align : center; color : #454545;">Sub Events</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active" style = "font-weight : 500;">Add New Sub Events</li>
</ol>

<form action="{{ route('adding_sub_event') }}" class="row g-3 mt-2" method="POST">
    @csrf
    <div class="col-md-6">
        <label class="form-label" for="inputSt">Event</label>
        <select class="form-select border border-secondary" id="inputSt" name="event_name" required>
            <option value="" selected disabled style = "text-align : center;">Select event to add sub-event</option>
            @if(isset($allEvents))
                @if(count($allEvents) > 0)
                    @foreach($allEvents as $eachEvent)
                        <option value="{{ $eachEvent->event_name }}">{{ $eachEvent->event_name }}</option>
                    @endforeach
                @endif
            @endif
        </select>
    </div>
    <div class="col-md-6">
    <label class="form-label" for="inputprj">Sub Event</label>
    <input class="form-control border border-secondary" id="inputprj" name="sub_event_name" placeholder="Enter sub-event name"
           required type="text" oninput="updateTotal()">
    </div>

    <br>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">Add Sub Event</button>
    </div>
</form>

<h1 class="mt-4" style = "text-align : center; color : #454545;">All Sub Events</h1>

<div class="mt-5">
    <table class="table">
        <thead>
            <tr>
                <th>Event Id</th>
                <th>Event Name</th>
                <th>Sub Events</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($allEvents))
                @if(count($allEvents) > 0)
                    @foreach($allEvents as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>
                                @if($event->subEvents->count() > 0)
                                    <table class="table">
                                        <thead>
                                            <tr style = "color : #454545;">
                                                <th>Sub Event Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($event->subEvents as $subEvent)
                                            <tr>
                                                <td>{{ $subEvent->sub_event_name }}</td>

                                                <td>
                                                    <button class="btn btn-success edit-btn" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{$subEvent->id}}"><i class="far fa-edit"></i></button>
                                                    <a class="btn btn-danger edit-btn" onclick = "return confirm('Are you sure to delete this Sub-event !')" href = "{{ route('deleting_sub_event', $subEvent->id) }}"><i class="fa-solid fa-trash"></i></a>

                                                    <div class="modal fade" id="editModal{{$subEvent->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$subEvent->id}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel{{$subEvent->id}}">Edit Sub Event</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="editForm{{$subEvent->id}}" method = "post" action = "{{ route('updating_sub_event', $subEvent->id) }}">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="taskSelect">Event Name</label>
                                                                            <select class="form-control" id="taskSelect" name = "event_id" required>
                                                                            @if(count($allEvents) > 0)
                                                                                @foreach($allEvents as $eachEvent)
                                                                                    <option value="{{ $eachEvent->id }}" {{ $eachEvent->id == $subEvent->event_id ? 'selected' : '' }}>
                                                                                        {{ $eachEvent->event_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            @endif
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        <div class="mb-3">
                                                                            <label for="editServiceSubName{{$subEvent->id}}" class="form-label">Sub Event Name</label>
                                                                            <input type="text" class="form-control" id="editServiceSubName{{$subEvent->id}}" value = "{{$subEvent->sub_event_name}}" name="sub_event_name" required>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    @if($subEvent->is_active == "1")
                                                        <a class="btn btn-light" onclick="return confirm('Are you sure to deactivate this Sub-event !')" href="{{ route('deactivating_sub_event', $subEvent->id) }}">
                                                            Deactivate
                                                        </a>
                                                    @endif

                                                    @if($subEvent->is_active == "0")
                                                        <a class="btn btn-light" onclick="return confirm('Are you sure to activate this Sub-event !')" href="{{ route('activating_sub_event', $subEvent->id) }}">
                                                            Activate
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                   <span style = "color : #454545;"><b> <i> No any sub-events added for this event</i></b></span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="3" style = "text-align: center; color : #454545;"> <b> No any event added yet to show sub-events ! </b></td>
                    </tr>
                @endif
            @endif

        </tbody>
    </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@include('admin_dashboard_footer')
