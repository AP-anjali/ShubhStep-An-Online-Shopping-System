@extends('admin_dashboard_layout')

@section('title')
<title>Accepted Exchange Orders</title>
@endsection

@section('style')
<style>
   .gfg {
            border-collapse:separate;
            border-spacing:0 15px;
        }

    #return_Accepted_Request{
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

          <div class = "col-md-12">
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

            @if (Session::has('OTP_SENT'))
                <div  id = "msg_notification">
                    <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                        <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                        <span style="flex-grow: 1;">{{ Session::get('OTP_SENT') }}</span>
                        <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                    </div>
                    <br>
                </div>
            @endif
          </div>

          <div class="col-md-4" style = "margin : auto ; margin-top : 2rem;">
            <form method = "post" action = "{{ route('return_otp_verification_process') }}">
                @csrf
                <div class="card">
                <div class="card-header">
                    <h4>OTP verification for return</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Order ID</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $Order->id }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>OTP</label>
                      <input style = "font-weight : 700;" type="text" maxlength="6" name = "input_otp" min="100000" max="999999"  class="form-control" value = "{{ old('input_otp') }}" required>
                    </div>

                    @if($Order->order_payment_status !== "authorized")
                        <div class="form-group">
                        <label>Payment Status</label>
                        <select class="form-control" name="payment_status" required>
                            <option value = "" style = "text-align : center;" selected disabled>-- &nbsp; Change Payment Status &nbsp; --</option>
                            <option value="authorized">Paid</option>
                        </select>
                        </div>
                    @endif

                    <input type="hidden" name="order_id" value = "{{ $Order->id }}">
                    <input type="hidden" name="customer_id" value = "{{ $Order->customer->id }}">
                    
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" type="submit">Verify</button>
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
    let Return_Request = document.getElementById("Return_Request");
    Return_Request.classList.add("active");
  </script>
@endsection