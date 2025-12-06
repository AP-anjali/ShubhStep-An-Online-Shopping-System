@extends('customer_dashboard_layout')

@section('title')
<title>Exchanged Orders</title>
@endsection

@section('style')
<style>
    .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }

    #Exchanged_Record{
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
                    <h4>Exchanged Orders</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(count($orders_data) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Order ID</th>
                                        <th>Product</th>
                                        <th>Name</th>
                                        <th>Quantity Ordered</th>
                                        <th>Paid Amount</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Delivered Date</th>
                                        <th>Request Status</th>
                                        <th>Exchnaged Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @php
                                    $srNo = 1;
                                @endphp

                                @foreach($orders_data as $data)

                                    <tr>
                                        <td style = "text-align : center;">{{ $srNo++ }}</td>
                                        <td style = "text-align : center;">{{ $data->id }}</td>

                                        <td>
                                            <img style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$data->product->id}}'" alt="image" src="{{ asset('storage/' . $data->product->thumbnail_image ) }}" width="100">
                                        </td>

                                        <td style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$data->product->id}}'">{{ $data->product->product_name }}</td>
                                        <td>{{ $data->product_quantity }}</td>
                                        <td>{{ number_format($data->product_price, 2) }}/-</td>
                                        <td>{{ $data->OrdersInvoice->payment_method }}</td>

                                        <td>
                                            @if($data->order_payment_status == 'authorized')
                                                <span style = "color : #006400; font-weight : 600;"><i class="fa-solid fa-circle-check"></i>&nbsp;paid</span>
                                            @else
                                                <span style = "color : #E10600; font-weight : 600;"><i class="fa-solid fa-circle-xmark"></i>&nbsp;Unpaid</span>
                                            @endif
                                        </td>

                                        <td>{{ $data->order_placed_date }}</td>
                                        <td>

                                            @if(($data->is_order_placed == 1) && ($data->is_order_cancelled == NULL && $data->is_order_accepted == NULL && $data->is_order_rejected == NULL))
                                                Pending
                                            @elseif($data->is_order_cancelled == 1)
                                                Cancelled
                                            @elseif($data->is_order_rejected == 1)
                                                Rejected
                                            @elseif(($data->is_order_accepted == 1) && ($data->is_order_ready == NULL))
                                                Accepted
                                            @elseif(($data->is_order_accepted == 1) && ($data->is_order_ready == 1) && ($data->is_order_delivered == NULL))
                                                Ready
                                            @elseif(($data->is_order_accepted == 1) && ($data->is_order_ready == 1) && ($data->is_order_delivered == 1))
                                                Delivered
                                            @endif

                                        </td>

                                        <td>{{ $data->order_delivered_date }}</td>

                                        <td>
                                            @if(($data->is_request_for_exchange_accepted) == NULL)
                                                Pending
                                            @elseif(($data->is_request_for_exchange_accepted == 1) && ($data->is_exchange_completed == 0))
                                                Accepted
                                            @elseif(($data->is_exchange_completed == 1))
                                                Exchanged
                                            @endif                                            
                                        </td>

                                        <td>{{ $data->exchange_completed_date }}</td>

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

</div>

@endsection

@section('script')
  <script>
    let Exchnage_Request = document.getElementById("Exchnage_Request");
    Exchnage_Request.classList.add("active");
  </script>
@endsection
