@extends('admin_dashboard_layout')

@section('title')
<title>Ready Orders</title>
@endsection

@section('style')
<style>
   .gfg {
            border-collapse:separate;
            border-spacing:0 15px;
        }

    #Ready_Record{
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
              <div class="col-12">
                  
                    @if (Session::has('success'))
                        <div  id = "msg_notification">
                        <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                            <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                            <span style="flex-grow: 1;">{{ Session::get('success') }}</span>
                            <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                            </div>
                            <br>
                        </div>
                    @endif

                            
                <div class="card">
                  <div class="card-header">
                    <h4>Ready Orders</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(isset($allReadyOrders))
                        @if(count($allReadyOrders) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                    <thead>
                                    <tr>

                                        <th class="text-center">No.</th>
                                        <th style="vertical-align: middle;">Order ID</th>
                                        <th style="vertical-align: middle;">Product ID</th>
                                        <th style="vertical-align: middle;">Thumbnail</th>
                                        <th style="vertical-align: middle;">Name</th>
                                        <th style="vertical-align: middle;">Quantity Ordered</th>
                                        <th style="vertical-align: middle;">Total Amount</th>
                                        <th style="vertical-align: middle;">Payment Method</th>
                                        <th style="vertical-align: middle;">Payment Status</th>
                                        <th style="vertical-align: middle;">Order Date</th>
                                        <th style="vertical-align: middle;">Accepted Date</th>
                                        <th style="vertical-align: middle;">Ready Mark Date</th>
                                        <th style="vertical-align: middle;">Customer Details</th>
                                        <th style="vertical-align: middle;">Undo Ready Mark</th>
                                        <th style="vertical-align: middle;">Mark As Delivered</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $srNo = 1; 
                                    @endphp

                                    @foreach($allReadyOrders as $eachOrder)

                                        <tr>
                                            <td style = "text-align : center;">{{ $srNo++ }}</td>
                                            <td style = "text-align : center;">{{ $eachOrder->id }}</td>
                                            <td style = "text-align : center;">{{ $eachOrder->product->id }}</td>
                                            
                                            <td>
                                                <img style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachOrder->product->id}}'" alt="image" src="{{ asset('storage/' . $eachOrder->product->thumbnail_image ) }}" width="100">
                                            </td>

                                            <td style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachOrder->product->id}}'">{{ $eachOrder->product->product_name }}</td>

                                            <td>{{ $eachOrder->product_quantity }}</td>                                    
                                            <td>{{ number_format($eachOrder->product_price, 2) }}/-</td>                                    
                                            <td>{{ $eachOrder->OrdersInvoice->payment_method }}</td>    

                                            <td>
                                                @if($eachOrder->order_payment_status == 'authorized')
                                                    <span style = "color : #006400; font-weight : 600;"><i class="fa-solid fa-circle-check"></i>&nbsp;paid</span>
                                                @else
                                                    <span style = "color : #E10600; font-weight : 600;"><i class="fa-solid fa-circle-xmark"></i>&nbsp;Unpaid</span>
                                                @endif
                                            </td>   

                                            <td>{{ $eachOrder->order_placed_date }}</td>    
                                            <td>{{ $eachOrder->order_accepted_date }}</td>    
                                            <td>{{ $eachOrder->order_ready_date }}</td>    
                                            

                                            <td>

                                                <form action="{{ route('customer_details_for_order') }}" method = "post" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="customer_id" value = "{{ $eachOrder->customer_id }}">
                                                    <button type="submit" class="btn btn-primary">Check</button>
                                                </form>

                                            </td>

                                            <td>
                                                <button type="button" onclick = "addModal({{ $eachOrder->id }})" class="btn btn-primary">Undo</button>
                                            </td>

                                            <td>
                                                <button type="button" onclick = "addModal2({{ $eachOrder->id }})" class="btn btn-primary">Mark</button>
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
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>

    <script>
        function addModal(OrderID) {

            var OrderId = OrderID;

            var AcceptUrl = "{{ route('undo_order_ready_mark', ':id') }}"; 

            AcceptUrl = AcceptUrl.replace(':id', OrderId);

            swal({
            title: 'Are you sure?',
            text: 'Are you sure to undo the ready mark of this order !',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                window.location.href = AcceptUrl;
                }
            });
        }

        function addModal2(OrderID) {

            var OrderId = OrderID;

            var AcceptUrl = "{{ route('send_otp_to_customer_for_verification', ':id') }}"; 

            AcceptUrl = AcceptUrl.replace(':id', OrderId);

            swal({
            title: 'Are you sure?',
            text: 'Are you sure to mark this order as delivered !',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                window.location.href = AcceptUrl;
                }
            });
        }
    </script>
@endsection

@section('script')
  <script>
    let orders = document.getElementById("orders");
    orders.classList.add("active");
  </script>
@endsection