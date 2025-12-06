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
                    <h4>Wishlist Products</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(count($wishlist_data) > 0)
                        <div class="table-responsive">
                        <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                            <thead>
                            <tr>
                                <th class="text-center">
                                No.
                                </th>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Actual Price</th>
                                <th>Discount Price</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                $srNo = 1; 
                            @endphp

                            @foreach($wishlist_data as $data)

                                <tr>
                                    <td style = "text-align : center;">
                                    {{ $srNo++ }}
                                    </td>

                                    <td>
                                    <img style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$data->product->id}}'" alt="image" src="{{ asset('storage/' . $data->product->thumbnail_image ) }}" width="100">
                                    </td>

                                    <td style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$data->product->id}}'">{{ $data->product->product_name }}</td>

                                    <td>{{ $data->product->price_without_discount }}/-</td>                                    

                                    <td>{{ $data->product->price_with_discount }}/-</td>                                    

                                    <td>

                                            <a onclick = "addModal({{$data->id}})" style="cursor: pointer; font-size: 1.1rem; color : #FF474C"><i class="fa-solid fa-trash"></i></a>
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
@endsection

@section('script')
  <script>
    let wishlist = document.getElementById("wishlist");
    wishlist.classList.add("active");

    function addModal(ProductID) {

        var ProductId = ProductID;

        var AcceptUrl = "{{ route('remove_from_wishlist', ':id') }}"; 

        AcceptUrl = AcceptUrl.replace(':id', ProductId);

        swal({
        title: 'Are you sure?',
        text: 'Are you sure to remove this product from your wishlist !',
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