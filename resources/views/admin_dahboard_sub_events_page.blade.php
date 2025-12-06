@extends('admin_dashboard_layout')

@section('title')
<title>Sub-events</title>
@endsection

@section('style')
<style>
    .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }
</style>
@endsection

@section('body')
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-6" style = "margin : auto;">
            <form method = "post" action = "{{ route('adding_sub_event') }}">
                @csrf
                <div class="card">
                <div class="card-header">
                    <h4>Add Sub-event</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Event Name</label>
                      <select style = "font-weight : 600;" class="form-control star-rating" name="event_name" required>
                          <option value = "" style = "text-align : center;" selected disabled>-- &nbsp; Select Event &nbsp; --</option>
                            @if(isset($allEvents))
                                @if(count($allEvents) > 0)
                                    @foreach($allEvents as $event)
                                        <option value="{{ $event->event_name }}">{{ $event->event_name }}</option>
                                    @endforeach
                                @endif
                            @endif
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Sub-event Name</label>
                      <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ old('sub_event_name') }}" name="sub_event_name" required>
                    </div>
                    
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Add Sub-event</button>
                </div>
                </div>
            </form>
          </div>


            <div class="col-12">

                    <div id = "successScroll"></div>
                
                    @if (Session::has('success'))
                        <div id = "msg_notification">
                            <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                <span style="flex-grow: 1;">{{ Session::get('success') }}</span>
                                <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                            </div>
                            <br>
                        </div>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $index => $error)
                            <div id="msg_notification_{{ $index }}">
                                <div style="background: #FF474C; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #B22222; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                    <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                    <span style="flex-grow: 1;">{{ $error }}</span>
                                    <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick="let box = document.getElementById('msg_notification_{{ $index }}'); box.style.display = 'none';" id = "close--btn2"></i>
                                </div>
                                <br>
                            </div>
                        @endforeach
                    @endif
                            
                <div class="card">
                    <div class="card-header">
                    <h4>All Sub-events</h4>
                    </div>
                    <div class="card-body">
                    
                        @if(count($allEvents) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Event Id</th>
                                            <th>Event Name</th>
                                            <th>Sub Events</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                            $srNo = 1; 
                                        @endphp

                                        @if(isset($allEvents))
                                            @if(count($allEvents) > 0)
                                                @foreach($allEvents as $event)

                                                    <tr>
                                                        <td style = "text-align : center;">{{ $srNo++ }}</td>
                                                        <td>{{ $event->id }}</td>
                                                        <td>{{ $event->event_name }}</td>

                                                        <td>
                                                            @if($event->subEvents->count() > 0)

                                                                <div class="table-responsive">
                                                                    <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">No.</th>
                                                                                <th>Sub Event Name</th>
                                                                                <th>Action</th>
                                                                                <th>Activation</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                                @php
                                                                                    $srNo2 = 1; 
                                                                                @endphp
                                                                            @foreach($event->subEvents as $subEvent)
                                                                                <tr>
                                                                                    <td style = "text-align : center;">{{ $srNo2++ }}</td>

                                                                                    <td>{{ $subEvent->sub_event_name }}</td>

                                                                                    <td>
                                                                                        <div style="display: flex; text-align : center; justify-content : center;">

                                                                                            <a href="#" style="cursor: pointer; margin-right: 10px; font-size: 1.1rem; color : #00ab41;" 
                                                                                            data-toggle="modal" data-target="#exampleModal" 
                                                                                            data-id="{{ $subEvent->id }}" 
                                                                                            data-sub_event_name="{{ $subEvent->sub_event_name }}"
                                                                                            data-EventNameOfSubEvent="{{ $subEvent->event->event_name }}"
                                                                                            data-EventIdOfSubEvent="{{ $subEvent->event->id }}"
                                                                                            onclick="populateModal(this)"><i class="fa-solid fa-pen-to-square"></i></a>

                                                                                            <a onclick = "addModal({{ $subEvent->id }})" style="cursor: pointer; font-size: 1.1rem; color : #FF474C"><i class="fa-solid fa-trash"></i></a>

                                                                                        </div>
                                                                                    </td>

                                                                                    <td>
                                                                                        @if($subEvent->is_active == "1")
                                                                                            <button type="button" onclick = "addDeactivationModal({{ $subEvent->id }})" class="btn btn-primary">Deactivate</button>
                                                                                        @endif

                                                                                        @if($subEvent->is_active == "0")
                                                                                            <button type="button" onclick = "addActivationModal({{ $subEvent->id }})" class="btn btn-primary">Activate</button>
                                                                                        @endif
                                                                                    </td>

                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table> 
                                                                </div>

                                                            @else
                                                                <span style = "color : #454545;"><b> <i> No any sub-events added for this event</i></b></span>
                                                            @endif
                                                        </td>
                                                
                                                    </tr>
                                                @endforeach
                                            @else
                                                <div style = "text-align : center;">
                                                    <img src="{{ asset('img/images/no_data.jpg') }}" id = "nothing">
                                                </div>
                                            @endif
                                        @endif
                                    
                                    </tbody>

                                </table>   
                            </div>

                        @else
                            <div style = "text-align : center;">
                                <img src="{{ asset('img/images/no_data.jpg') }}" id = "nothing">
                            </div>
                        @endif
                    </div>
                </div>

                </div>
            </div>

      </div>
    </section>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModal">Edit Sub-event Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="updateForm">
                            @csrf

                            <input type="hidden" name="sub_event_id" id="sub_event_id">
                            <input type="hidden" name="event_id" id="sub_event_EventID">

                            <div class="form-group">
                                <label>Event Name</label>
                                <select style = "font-weight : 600;" class="form-control star-rating" id="modal_event_name" name="event_id" required>
                                    @if(isset($allEvents))
                                        @if(count($allEvents) > 0)
                                            @foreach($allEvents as $eachEvent)
                                                <option value="{{ $eachEvent->id }}">{{ $eachEvent->event_name }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Sub-event name" name="sub_event_name" id="sub_event_name" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    function populateModal(element) {
        var SubEventID = element.getAttribute('data-id');
        var SubEventName = element.getAttribute('data-sub_event_name');
        var EventNameOfSubEvent = element.getAttribute('data-EventNameOfSubEvent');
        var EventIdOfSubEvent = element.getAttribute('data-EventIdOfSubEvent');

        document.getElementById('sub_event_id').value = SubEventID;
        document.getElementById('sub_event_EventID').value = EventIdOfSubEvent;
        document.getElementById('sub_event_name').value = SubEventName;

        var eventDropdown = document.getElementById('modal_event_name');

        for (var i = 0; i < eventDropdown.options.length; i++) {
            if (eventDropdown.options[i].value == EventIdOfSubEvent) {
                eventDropdown.options[i].selected = true;
                break;
            }
        }

        var updateForm = document.getElementById('updateForm');
        var updateUrl = "{{ route('updating_sub_event', ':id') }}";
        updateUrl = updateUrl.replace(':id', SubEventID);
        updateForm.action = updateUrl;
    }
</script>

<script>
    function addModal(SubEventID) {

        var sub_eventId = SubEventID;

        var DeleteUrl = "{{ route('deleting_sub_event', ':id') }}"; 

        DeleteUrl = DeleteUrl.replace(':id', sub_eventId);

        swal({
        title: 'Are you sure?',
        text: 'Are you sure to delete this sub-event !',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            window.location.href = DeleteUrl;
            }
        });
    }

    function addDeactivationModal(EventID) {
        var eventId = EventID;

        var DeactivateUrl = "{{ route('deactivating_sub_event', ':id') }}"; 

        DeactivateUrl = DeactivateUrl.replace(':id', eventId);

        swal({
        title: 'Are you sure?',
        text: 'Are you sure to deactivate this sub-event !',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            window.location.href = DeactivateUrl;
            }
        });
    }

    function addActivationModal(EventID) {
        var eventId = EventID;

        var ActivateUrl = "{{ route('activating_sub_event', ':id') }}"; 

        ActivateUrl = ActivateUrl.replace(':id', eventId);

        swal({
        title: 'Are you sure?',
        text: 'Are you sure to activate this sub-event !',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            window.location.href = ActivateUrl;
            }
        });
    }
</script>
@endsection

@section('script')
  <script>
    let Sub_events = document.getElementById("Sub_events");
    Sub_events.classList.add("active");
  </script>
@endsection