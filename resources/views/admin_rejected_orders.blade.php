@extends('admin_dashboard_layout')

@section('title')
<title>New Orders</title>
@endsection

@section('style')
<style>
   .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }

    #Rejected_Record{
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
                    <h4>Rejected Orders</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(isset($allRejectedOrders))
                        @if(count($allRejectedOrders) > 0)
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
                                        <th style="vertical-align: middle;">Rejected Date</th>
                                        <th style="vertical-align: middle;">Rejection Reason</th>
                                        <th style="vertical-align: middle;">Customer Details</th>
                                        <th style="vertical-align: middle;">Refund Status</th>
                                        <th style="vertical-align: middle;">Refund Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $srNo = 1; 
                                    @endphp

                                    @foreach($allRejectedOrders as $eachOrder)

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
                                            <td>{{ $eachOrder->order_payment_status }}</td>    

                                            <td>
                                                @if($eachOrder->order_payment_status == 'authorized')
                                                    <span style = "color : #006400; font-weight : 600;"><i class="fa-solid fa-circle-check"></i>&nbsp;paid</span>
                                                @else
                                                    <span style = "color : #E10600; font-weight : 600;"><i class="fa-solid fa-circle-xmark"></i>&nbsp;Unpaid</span>
                                                @endif
                                            </td>

                                            <td>{{ $eachOrder->order_placed_date }}</td>    
                                            <td>{{ $eachOrder->order_rejected_date }}</td>    
                                            <td>{{ $eachOrder->order_reject_reason }}</td>    
                                            

                                            <td>

                                                <form action="{{ route('customer_details_for_order') }}" method = "post" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="customer_id" value = "{{ $eachOrder->customer_id }}">
                                                    <button type="submit" class="btn btn-primary">Check</button>
                                                </form>

                                            </td>

                                            <td>

                                                @if($eachOrder->OrdersInvoice->payment_method != "COD")

                                                    @if($eachOrder->is_payment_refunded == 1)
                                                        Refunded
                                                    @else
                                                        Pending
                                                    @endif

                                                @endif

                                                @if($eachOrder->OrdersInvoice->payment_method == "COD")
                                                    It was COD
                                                @endif
                                            </td>

                                            <td>
                                                @if($eachOrder->OrdersInvoice->payment_method != "COD")
                                                    {{ $eachOrder->payment_refunded_date ? $eachOrder->payment_refunded_date : '-----';}}
                                                @endif

                                                @if($eachOrder->OrdersInvoice->payment_method == "COD")
                                                    -----
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
                    @endif
                  </div>
                </div>
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