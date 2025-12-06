@extends('admin_dashboard_layout')

@section('title')
<title>All Products</title>
@endsection

@section('style')
<style>
   .gfg {
            border-collapse:separate;
            border-spacing:0 15px;
        }

    #Uploded_product{
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
                    <h4>All Products</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(count($allProducts) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Product ID</th>
                                    <th>Thumbnail Image</th>
                                    <th>Product Name</th>
                                    <th>Actual Price</th>
                                    <th>Discount Price</th>
                                    <th>Quantity</th>
                                    <th>Event Name</th>
                                    <th>Sub-event Name</th>
                                    <th>Action</th>
                                    <th>Activation</th>
                                </tr>
                                </thead>
                                <tbody>

                                @php
                                    $srNo = 1; 
                                @endphp

                                @foreach($allProducts as $eachProduct)

                                    <tr>
                                        <td style = "text-align : center;">{{ $srNo++ }}</td>
                                        <td style = "text-align : center;">{{ $eachProduct->id }}</td>
                                        
                                        <td>
                                            <img style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'" alt="image" src="{{ asset('storage/' . $eachProduct->thumbnail_image ) }}" width="100">
                                        </td>

                                        <td style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'">{{ $eachProduct->product_name }}</td>

                                        <td>{{ $eachProduct->price_without_discount }}/-</td>                                    
                                        <td>{{ $eachProduct->price_with_discount }}/-</td>                                    
                                        <td>{{ $eachProduct->product_quantity }}</td>    
                                        <td>{{ $eachProduct->product_event_name }}</td>    
                                        <td>{{ $eachProduct->product_sub_event_name }}</td>    
                                        
                                        <td>
                                            <div style="display: flex;">
                                                <form action="{{ route('admin_dashboard_edit_product_page') }}" id = "edit_form_{{ $loop->index }}" method = "post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value = "{{ $eachProduct->id }}">
                                                    <a onclick = "let form = document.getElementById('edit_form_{{ $loop->index }}'); form.submit();" style="cursor: pointer; margin-right: 10px; font-size: 1.1rem; color : #00ab41; border : none; background : none;"><i class="fa-solid fa-pen-to-square"></i></a>
                                                </form>
                                                <a onclick = "addModal({{ $eachProduct->id }})" style="cursor: pointer; margin-right: 10px; font-size: 1.1rem; color : #FF474C"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>

                                        <td>
                                            @if($eachProduct->is_active == "1")
                                                <button type="button" onclick = "addDeactivationModal({{ $eachProduct->id }})" class="btn btn-primary">Deactivate</button>
                                            @endif

                                            @if($eachProduct->is_active == "0")
                                                <button type="button" onclick = "addActivationModal({{ $eachProduct->id }})" class="btn btn-primary">Activate</button>
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
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>

    <script>
        function addModal(EventID) {

            var eventId = EventID;

            var DeleteUrl = "{{ route('deleting_product', ':id') }}"; 

            DeleteUrl = DeleteUrl.replace(':id', eventId);

            swal({
            title: 'Are you sure?',
            text: 'Are you sure to delete this product !',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                window.location.href = DeleteUrl;
                }
            });
        }

        function addDeactivationModal(EventID) {
            var eventId = EventID;

            var DeactivateUrl = "{{ route('deactivating_product', ':id') }}"; 

            DeactivateUrl = DeactivateUrl.replace(':id', eventId);

            swal({
            title: 'Are you sure?',
            text: 'Are you sure to deactivate this product !',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                window.location.href = DeactivateUrl;
                }
            });
        }

        function addActivationModal(EventID) {
            var eventId = EventID;

            var ActivateUrl = "{{ route('activating_product', ':id') }}"; 

            ActivateUrl = ActivateUrl.replace(':id', eventId);

            swal({
            title: 'Are you sure?',
            text: 'Are you sure to activate this product !',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                window.location.href = ActivateUrl;
                }
            });
        }
    </script>
@endsection

@section('script')
  <script>
    let Products = document.getElementById("Products");
    Products.classList.add("active");
  </script>
@endsection