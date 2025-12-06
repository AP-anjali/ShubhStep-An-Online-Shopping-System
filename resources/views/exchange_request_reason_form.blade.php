@extends('customer_dashboard_layout')

@section('title')
<title>Request for exchange</title>
@endsection

@section('style')
<style>
    .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }

    #Completed_Record{
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
            <form method = "post" action = "{{ route('exchange_request') }}">
                @csrf
                <div class="card">
                <div class="card-header">
                    <h4>Order Exchange Request Reason Form</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Product Name</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $ExchangeOrderData->product->product_name }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Product Title</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $ExchangeOrderData->product->product_title }}" readonly>
                    </div>
                    
                    <div class="form-group">
                      <label>Order Exchange Request Reason</label>
                      <textarea class="form-control" name = "exchange_request_reason" required></textarea>
                    </div>

                    <input type="hidden" name="order_id" value = "{{ $ExchangeOrderData->id }}">
                    
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