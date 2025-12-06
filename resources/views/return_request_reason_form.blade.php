@extends('customer_dashboard_layout')

@section('title')
<title>Request for return</title>
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

          @if ($errors->any())
            @foreach ($errors->all() as $index => $error)
                <div class="col-md-12">
                  <div id="msg_notification_{{ $index }}">
                      <div style="background: #FF474C; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #B22222; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                          <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                          <span style="flex-grow: 1;">{{ $error }}</span>
                          <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick="let box = document.getElementById('msg_notification_{{ $index }}'); box.style.display = 'none';" id = "close--btn2"></i>
                      </div>
                      <br>
                  </div>
                </div>
            @endforeach
          @endif

          @if(isset($returnOrderData))
            @if($returnOrderData->OrdersInvoice->payment_method !== 'COD')
              <div class="col-12 col-md-6 col-lg-6" style = "margin : auto ; margin-top : 1rem;">
                <form method = "post" action = "{{ route('return_request') }}">
                    @csrf
                    <div class="card">
                    <div class="card-header">
                        <h4>Order Return Request Reason Form</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                          <label>Product Name</label>
                          <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $returnOrderData->product->product_name }}" readonly>
                        </div>

                        <div class="form-group">
                          <label>Product Title</label>
                          <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $returnOrderData->product->product_title }}" readonly>
                        </div>
                        
                        <div class="form-group">
                          <label>Order Return Request Reason</label>
                          <textarea class="form-control" name = "return_request_reason" required></textarea>
                        </div>

                        <input type="hidden" name="order_id" value = "{{ $returnOrderData->id }}">
                        
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    </div>
                    </div>
                </form>
              </div>
            @endif

            @if($returnOrderData->OrdersInvoice->payment_method === 'COD')
              <div class="col-md-12" style = "margin : auto ; margin-top : 1rem;">
                <form method = "post" action = "{{ route('return_request') }}">
                    @csrf
                    <div class="card">
                    <div class="card-header">
                        <h4>Order Return Request Reason Form</h4>
                    </div>
                    <div class="card-body">

                        <input type="hidden" name="order_id" value = "{{ $returnOrderData->id }}">
                        <input type="hidden" name="COD" value = "1">

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label>Product Name</label>
                            <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $returnOrderData->product->product_name }}" readonly>
                          </div>

                          <div class="form-group col-md-6">
                            <label>Product Title</label>
                            <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $returnOrderData->product->product_title }}" readonly>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label>Order Return Request Reason</label>
                          <textarea class="form-control" name = "return_request_reason" required></textarea>
                        </div>

                        <hr>
                        <div class="form-group" style = "text-align : center; margin-bottom : 0px;">
                          <label style = "font-weight : 700; font-size: 0.8rem;"><u>Bank Details For Refund</u></label>
                        </div>
                        <hr>

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label>Bank Account Holder Name</label>
                            <input style = "font-weight : 700;" type="text" class="form-control" name = "Bank_Account_Holder_Name" value = "{{ old('Bank_Account_Holder_Name') }}" required>
                          </div>

                          <div class="form-group col-md-6">
                            <label>Bank Account Number</label>
                            <input style = "font-weight : 700;" type="text" class="form-control" name = "Bank_Account_Number" value = "{{ old('Bank_Account_Number') }}" required>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label>Bank Name</label>
                            <input style = "font-weight : 700;" type="text" class="form-control" name = "Bank_Name" value = "{{ old('Bank_Name') }}" required>
                          </div>

                          <div class="form-group col-md-6">
                            <label>IFSC Code</label>
                            <input style = "font-weight : 700;" type="text" class="form-control" name = "IFSC_Code" value = "{{ old('IFSC_Code') }}" required pattern=".{11}" title="The IFSC code must be exactly 11 characters long.">
                          </div>
                        </div>

                        
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    </div>
                    </div>
                </form>
              </div>
            @endif
          @endif

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
