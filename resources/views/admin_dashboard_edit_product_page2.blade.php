@include('admin_dashboard_header2')
<!-- <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Add new product</li>
</ol> -->

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

@if (Session::has('unmatch_event_subEvent'))
    <br><br>
    <div id="errorAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get('unmatch_event_subEvent') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<h1 class="mt-4" style = "text-align : center; color : #454545;">Edit product data</h1>

<form action="{{ route('updating_product', $product_to_update->id) }}" class="row g-3 mt-2" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="col-md-6">
        <label class="form-label" for="inputmentor">Product Name</label>
        <input class="form-control border border-secondary" id="inputprj" value="{{ $product_to_update->product_name }}" name="product_name" placeholder="Enter product name"
               required type="text">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputprj">Product Title</label>
        <input class="form-control border border-secondary" id="inputprj" value="{{ $product_to_update->product_title }}" name="product_title" placeholder="Enter product title"
               required type="text">
    </div>

    <div class="col-12">
        <label class="form-label" for="inputgp">Product Description</label>
        <input class="form-control border border-secondary" id="inputgp" name="product_description" value="{{ $product_to_update->product_description }}" placeholder="Enter product description" required
               type="text">
    </div>

    
    <div class="col-md-4">
    <label class="form-label" for="inputprj">Price Without Discount</label>
    <input class="form-control border border-secondary" id="inputprj" name="price_without_discount" value="{{ $product_to_update->price_without_discount }}" placeholder="Product price without discount"
           required type="number">
    </div>

    <div class="col-md-4">
    <label class="form-label" for="inputprj">Price With Discount</label>
    <input class="form-control border border-secondary" id="inputprj" name="price_with_discount" value="{{ $product_to_update->price_with_discount }}" placeholder="Product price with discount"
           required type="number">
    </div>

    <div class="col-md-4">
    <label class="form-label" for="inputprj">Product Quantity</label>
    <input class="form-control border border-secondary" id="inputprj" name="product_quantity" value="{{ $product_to_update->product_quantity }}" placeholder="Product Quantity"
           required type="number">
    </div>



    <div class="col-md-6">
        <label class="form-label" for="inputprj">Product Thumbnail Image [optional]</label>
        <input class="form-control border border-secondary" id="thumbnail_image_tag" name="thumbnail_image" placeholder="Product price without discount"
            type="file">
    </div>

    <div class="col-md-6">
        <label class="form-label" for="inputprj">Product Other Images [optional]</label>
        <input class="form-control border border-secondary" id="other_image_tag" name="other_images[]" placeholder="Product price with discount"
            type="file" multiple>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Product Event</label>
        <select class="form-select border border-secondary" id="event_id" name="event_id" required>
            @if(count($allEvents) > 0)
                @foreach($allEvents as $eachEvent)
                    <option value="{{ $eachEvent->id }}" {{ $eachEvent->id == $product_to_update->event_id ? 'selected' : '' }}>
                        {{ $eachEvent->event_name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Product Sub Event</label>
        <select class="form-select border border-secondary" id="sub_event_id" name="sub_event_id" required>
            @if(count($allEvents) > 0)
                @foreach($allEvents as $eachEvent)
                    <option value="" disabled>{{$eachEvent->event_name}}</option>

                    @foreach($eachEvent->subEvents as $subEvent)
                        <option value="{{ $subEvent->id }}" {{ $subEvent->id == $product_to_update->sub_event_id ? 'selected' : '' }}>
                            &nbsp;&nbsp;&nbsp;{{ $subEvent->sub_event_name }}
                        </option>
                    @endforeach

                @endforeach
            @endif
        </select>
    </div>
    <br>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">Update Product</button>
    </div>

</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function validateImages(input) {
        var hasError = false; 

        if (input.files && input.files.length > 0) {
            for (var i = 0; i < input.files.length; i++) {
                var image = input.files[i];
                var img = new Image();

                
                (function(index) {
                    img.onload = function() {
                        if (this.width > 515 || this.height > 685) {
                            hasError = true; 
                        }

                        if (index === input.files.length - 1) {
                            if (hasError) {
                                alert('Image dimensions is much high [perfect image must be : 515 pixel width | 685 pixel height]');
                                input.value = ''; 
                            }
                        }
                    };
                })(i); 

                img.src = URL.createObjectURL(image);
            }
        }
    }

    document.getElementById('thumbnail_image_tag').addEventListener('change', function(event) {
        validateImages(event.target);
    });

    document.getElementById('other_image_tag').addEventListener('change', function(event) {
        validateImages(event.target);
    });
</script>

@include('admin_dashboard_footer2')
