@include('admin_dashboard_header2')

@if ($errors->any())
    <br><br>
    <div id="errorAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('success'))
    <br><br>
    <div id="successAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('update_success'))
    <br><br>
    <div id="successAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('update_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->

<h1 class="mt-4" style = "text-align : center; color : #454545;">All Products</h1>

<table class="table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Discount Price</th>
            <th>Quntity</th>
            <th>Thumbnail</th>
            <th>Action</th>
        </tr>
    </thead>


    <tbody>
        @if(isset($allProducts))
        @if(count($allProducts) > 0)
            @foreach($allProducts as $eachproduct)
                <tr>
                    <td style="vertical-align: middle;">{{ $eachproduct->id }}</td>
                    <td style="vertical-align: middle; cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachproduct->id}}'">{{ $eachproduct->product_name }}</td>
                    <td style="vertical-align: middle;">&#8377; {{ $eachproduct->price_without_discount }}/-</td>
                    <td style="vertical-align: middle;">&#8377; {{ $eachproduct->price_with_discount }}/-</td>
                    <td style="vertical-align: middle;">{{ $eachproduct->product_quantity }}</td>
                    <td style="max-width: 100px; vertical-align: middle;">
                        <img src="{{ asset('storage/' . $eachproduct->thumbnail_image ) }}" style="max-width: 80%; height: auto; cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachproduct->id}}'" alt="Thumbnail Image">
                    </td>

                    <td style="vertical-align: middle;">
                        <a class="btn btn-success edit-btn" onclick = "return confirm('Are you sure to edit this product !')" href = "{{ route('admin_dashboard_edit_product_page', $eachproduct->id) }}"><i class="far fa-edit"></i></a>
                        <a class="btn btn-danger edit-btn" onclick = "return confirm('Are you sure to delete this product !')" href = "{{ route('deleting_product', $eachproduct->id) }}"><i class="fa-solid fa-trash"></i></a>

                        @if($eachproduct->is_active == "1")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to deactivate this product !')" href="{{ route('deactivating_product', $eachproduct->id) }}">
                                Deactivate
                            </a>
                        @endif

                        @if($eachproduct->is_active == "0")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to activate this product !')" href="{{ route('activating_product', $eachproduct->id) }}">
                                Activate
                            </a>
                        @endif

                    </td>
                </tr>
            @endforeach

        @else
            <tr>
                <td colspan="7" style = "text-align: center; color : #454545;"><b>No any product uploaded yet !</b></td>
            </tr>
        @endif
        @endif

    </tbody>
</table>

               
@include('admin_dashboard_footer2')
