@extends('admin_dashboard_layout')

@section('title')
<title>Events</title>
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
            <form method = "post" action = "{{ route('adding_event') }}">
                @csrf
                <div class="card">
                <div class="card-header">
                    <h4>Add Event</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Event Name</label>
                      <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ old('event_name') }}" name="event_name" required>
                    </div>
                    
                    <div class="form-group">
                      <label>Event Description</label>
                      <textarea class="form-control" style = "font-weight : 600;" name = "description" required>{{ old('description') }}</textarea>
                    </div>
                    
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Add Event</button>
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
                    <h4>All Events</h4>
                    </div>
                    <div class="card-body">
                    
                        @if(count($allEvents) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Event ID</th>
                                            <th>Event Name</th>
                                            <th>Event Description</th>
                                            <th>Action</th>
                                            <th>Activation</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                            $srNo = 1; 
                                            $totalPrice = 0.0; 
                                        @endphp

                                        @foreach($allEvents as $eachEvent)

                                            <tr>
                                                <td style = "text-align : center;">{{ $srNo++ }}</td>
                                                <td>{{ $eachEvent->id }}</td>
                                                <td>{{ $eachEvent->event_name }}</td>
                                                <td>{{ $eachEvent->description }}</td>

                                                <td>
                                                    <div style="display: flex; text-align : center; justify-content : center;">

                                                        <a href="#" style="cursor: pointer; margin-right: 10px; font-size: 1.1rem; color : #00ab41;" 
                                                        data-toggle="modal" data-target="#exampleModal" 
                                                        data-id="{{ $eachEvent->id }}" 
                                                        data-event_name="{{ $eachEvent->event_name }}"
                                                        data-description="{{ $eachEvent->description }}"
                                                        onclick="populateModal(this)"><i class="fa-solid fa-pen-to-square"></i></a>

                                                        <a onclick = "addModal({{ $eachEvent->id }})" style="cursor: pointer; font-size: 1.1rem; color : #FF474C"><i class="fa-solid fa-trash"></i></a>

                                                    </div>
                                                </td>

                                                <td>
                                                    @if($eachEvent->is_active == "1")
                                                        <button type="button" onclick = "addDeactivationModal({{ $eachEvent->id }})" class="btn btn-primary">Deactivate</button>
                                                    @endif

                                                    @if($eachEvent->is_active == "0")
                                                        <button type="button" onclick = "addActivationModal({{ $eachEvent->id }})" class="btn btn-primary">Activate</button>
                                                    @endif
                                                </td>
                                        
                                            </tr>
                                        @endforeach
                            
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
                        <h5 class="modal-title" id="formModal">Edit Event Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action = "{{ route('updating_event') }}">
                            @csrf
                            <input type="hidden" name="event_id" id="event_id">

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Event name" name="event_name" id="event_name" required>
                                </div>

                                <div class="input-group" style = "margin-top : 1.5rem;">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Event Description" name="description" id="description" required>
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
        var EventID = element.getAttribute('data-id');
        var EventName = element.getAttribute('data-event_name');
        var EventDesc = element.getAttribute('data-description');

        document.getElementById('event_id').value = EventID;
        document.getElementById('event_name').value = EventName;
        document.getElementById('description').value = EventDesc;
    }
</script>

<script>
    function addModal(EventID) {

        var eventId = EventID;

        var DeleteUrl = "{{ route('deleting_event', ':id') }}"; 

        DeleteUrl = DeleteUrl.replace(':id', eventId);

        swal({
        title: 'Are you sure?',
        text: 'Are you sure to delete this event !',
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

        var DeactivateUrl = "{{ route('deactivating_event', ':id') }}"; 

        DeactivateUrl = DeactivateUrl.replace(':id', eventId);

        swal({
        title: 'Are you sure?',
        text: 'Are you sure to deactivate this event !',
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

        var ActivateUrl = "{{ route('activating_event', ':id') }}"; 

        ActivateUrl = ActivateUrl.replace(':id', eventId);

        swal({
        title: 'Are you sure?',
        text: 'Are you sure to activate this event !',
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

    document.addEventListener('DOMContentLoaded', function() {
        @if (Session::has('success'))
            let successScroll = document.getElementById('successScroll');
            successScroll.scrollIntoView({ behavior: 'smooth' });
        @endif
    });

    let Events = document.getElementById("Events");
    Events.classList.add("active");
  </script>
@endsection