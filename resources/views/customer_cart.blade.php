@extends('customer_dashboard_layout')

@section('title')
<title>Customer Cart</title>
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
                    <h4>Cart Products</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(count($cart_data) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                    No.
                                    </th>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Place Order</th>
                                    <th>Action</th>
                                    <th id = "quantity">Quantity</th>
                                    <th>Sub Total</th>
                                </tr>
                                </thead>
                                <tbody>

                                @php
                                    $srNo = 1; 
                                    $totalPrice = 0.0; 
                                @endphp

                                @foreach($cart_data as $data)

                                    @php
                                        $totalPrice += (float)$data->total_products_price_with_discount;
                                    @endphp

                                    <tr>
                                        <td style = "text-align : center;">
                                        {{ $srNo++ }}
                                        </td>

                                        <td>
                                        <img style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$data->product->id}}'" alt="image" src="{{ asset('storage/' . $data->product->thumbnail_image ) }}" width="100">
                                        </td>

                                        <td style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$data->product->id}}'">{{ $data->product->product_name }}</td>

                                        <td>

                                            <form method = "post" action = "{{ route('buy_now') }}" id="buy-now-form">
                                                @csrf

                                                <input type="hidden" name="product_id" value = "{{ $data->product->id }}">
                                                <input type="hidden" name="product_price_without_discount" value = "{{ $data->total_products_price_without_discount }}">
                                                <input type="hidden" name="product_price_with_discount" value = "{{ $data->total_products_price_with_discount }}">
                                                <input type="hidden" name="fromCart" value = "1">
                                                <input type="hidden" name="cartRecordID" value = "{{ $data->id }}">

                                                @if(isset($customer_session))
                                                    <input type="hidden" name="customer_id" value = "{{ $customer_session->id }}">
                                                @endif

                                                <input type="hidden" name="quantity" value = "{{ $data->quantity }}">

                                                <button type = "submit" class="badge badge-primary badge-shadow cartBuyNowBtn">Buy</button>
                                            </form>

                                        </td>

                                        <td>
                                            <div style="display: flex;">

                                                <a onclick = "addModal({{$data->id}})" style="cursor: pointer; margin-right: 10px; font-size: 1.1rem; color : #FF474C"><i class="fa-solid fa-trash"></i></a>

                                                <a href="#" style="cursor: pointer; font-size: 1.1rem; color : #00ab41;" 
                                                data-toggle="modal" data-target="#exampleModal" 
                                                data-id="{{ $data->id }}" 
                                                data-quantity="{{ $data->quantity }}"
                                                onclick="populateModal(this)"><i class="fa-solid fa-pen-to-square"></i></a>

                                            </div>
                                        </td>

                                        <td>
                                            <input type="number" value = "{{ $data->quantity }}" class="form-control" id = "cart_text" readonly>
                                        </td>

                                        <td>{{ $data->total_products_price_with_discount }}/-</td>                                    
                                    </tr>
                                @endforeach
                            
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th style = "text-align : center;">
                                    <strong>TOTAL</strong>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>{{ number_format($totalPrice, 2) }}/-</th>
                                </tr>
                                </tfoot>
                            </table>

                            <div style="text-align: center;">
                                <form method="post" action="{{ route('checkout') }}">
                                    @csrf
                                    
                                    @foreach($cart_data as $index => $data)
                                        <input type="hidden" name="products[{{ $index }}][product_id]" value="{{ $data->product->id }}">
                                        <input type="hidden" name="products[{{ $index }}][product_price_without_discount]" value="{{ $data->total_products_price_without_discount }}">
                                        <input type="hidden" name="products[{{ $index }}][product_price_with_discount]" value="{{ $data->total_products_price_with_discount }}">
                                        <input type="hidden" name="products[{{ $index }}][quantity]" value="{{ $data->quantity }}">
                                    @endforeach

                                    <input type="hidden" name="fromCart" value = "1">

                                    @if(isset($customer_session))
                                        <input type="hidden" name="customer_id" value="{{ $customer_session->id }}">
                                    @endif

                                    <button type="submit" class="btn btn-primary">Check Out</button>
                                </form>
                            </div>


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
                        <h5 class="modal-title" id="formModal">Edit Quantity</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action = "{{ route('updating_cart_record') }}">
                            @csrf
                            <input type="hidden" name="product_id" id="modal_product_id">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                    <input type="number" min="1" class="form-control" placeholder="Quantity" name="quantity" id="modal_quantity" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>

        function initializeRazorpay(index, amount)
        {
            var amountInPaise = amount * 100;

            var options = {
                "key": "{{ env('RAZORPAY_API_KEY') }}",
                "amount": amountInPaise.toString(), 
                "currency": "INR",
                "name": "SHUBHSTEP",
                "description": "An online shopping platform",
                "image": "",
                "handler": function (response){
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('payment-form').submit();
                },
                "prefill": {
                    "name": "Anjali Patel",
                    "email": "anjalipatel3074@gmail.com"
                },
                "theme": {
                    "color": "#8789ff"
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        }

        function addModal(ProductID) {

            var ProductId = ProductID;

            var AcceptUrl = "{{ route('remove_from_cart', ':id') }}"; 

            AcceptUrl = AcceptUrl.replace(':id', ProductId);

            swal({
            title: 'Are you sure?',
            text: 'Are you sure to remove this product from your cart !',
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

<script>
    function populateModal(element) {
        var productId = element.getAttribute('data-id');
        var quantity = element.getAttribute('data-quantity');

        document.getElementById('modal_product_id').value = productId;
        document.getElementById('modal_quantity').value = quantity;
    }
</script>
@endsection

@section('script')
  <script>
    let cart = document.getElementById("cart");
    cart.classList.add("active");
  </script>
@endsection