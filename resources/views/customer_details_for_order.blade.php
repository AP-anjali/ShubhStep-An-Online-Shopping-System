@extends('admin_dashboard_layout')

@section('title')
<title>Customer Details</title>
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
                    <h4>Customer Details</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Name</label>
                      <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customer->name }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Email</label>
                      <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customer->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>contact number</label>
                      <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customer->phone_no }}" readonly>
                    </div>                    
                </div>
                </div>
            </form>
          </div>
        </div>

        <div class = "row">
            <div class="col-12" style = "margin : auto;">
                <form method = "post" action = "{{ route('adding_event') }}">
                    @csrf
                    <div class="card">
                    <div class="card-header">
                        <h4>Customer Address Details</h4>
                    </div>
                    <div class="card-body">

                        <div class = "row">
                            <div class="form-group col-md-6">
                                <label>Country</label>
                                <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customerAddress->country }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>State</label>
                                <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customerAddress->state }}" readonly>
                            </div>
                        </div>

                        <div class = "row">
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customerAddress->city }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Area/Village</label>
                                <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customerAddress->area_or_village }}" readonly>
                            </div>
                        </div>

                        <div class = "row">
                            <div class="form-group col-md-6">
                                <label>Pincode</label>
                                <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customerAddress->pincode }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Landmark</label>
                                <input style = "font-weight : 600;" type="text" class="form-control" value = "{{ $customerAddress->landmark }}" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Full Address</label>
                            <textarea class="form-control" style = "font-weight : 600;" readonly>{{ $customerAddress->full_address }}</textarea>
                        </div>
                        
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
  <script>
    let orders = document.getElementById("orders");
    orders.classList.add("active");
  </script>
@endsection