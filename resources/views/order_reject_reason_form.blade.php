@extends('admin_dashboard_layout')

@section('title')
<title>Request for return</title>
@endsection

@section('style')
<style>
    .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }

    #New_Record{
        font-weight : 700 !important;
        color : #454545 !important;
    }
</style>
@endsection

@section('body')
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-6" style = "margin : auto ; margin-top : 1rem;">
            <form method = "post" action = "{{ route('order_reject', $rejectOrderData->id) }}">
                @csrf
                <div class="card">
                <div class="card-header">
                    <h4>Order Reject Reason Form</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Product Name</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $rejectOrderData->product->product_name }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Product Title</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $rejectOrderData->product->product_title }}" readonly>
                    </div>
                    
                    <div class="form-group">
                      <label>Order Reject Reason</label>
                      <textarea class="form-control" name = "order_reject_reason" required></textarea>
                    </div>

                    <input type="hidden" name="order_id" value = "{{ $rejectOrderData->id }}">
                    
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                </div>
                </div>
            </form>
          </div>
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
