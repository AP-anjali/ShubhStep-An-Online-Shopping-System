@extends('customer_dashboard_layout')

@section('title')
<title>Request for cancel</title>
@endsection

@section('style')
<style>
    .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }

    #Orders_Record{
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
            <form method = "post" action="{{ route('order.cancel', $cancelledOrderData->id) }}">
                @csrf
                <div class="card">
                <div class="card-header">
                    <h4>Order Cancel Reason Form</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Product Name</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $cancelledOrderData->product->product_name }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Product Title</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $cancelledOrderData->product->product_title }}" readonly>
                    </div>
                    
                    <div class="form-group">
                      <label>Order Cancel Reason</label>
                      <textarea class="form-control" name = "order_cancel_reason" required></textarea>
                    </div>

                    <input type="hidden" name="order_id" value = "{{ $cancelledOrderData->id }}">
                    
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
