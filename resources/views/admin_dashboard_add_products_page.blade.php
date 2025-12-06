@extends('admin_dashboard_layout')

@section('title')
<title>Add Products</title>
@endsection

@section('style')
<style>
    .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }

    #add_product{
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
            <div class="col-md-12" style = "margin : auto;">

                    @if (Session::has('success'))
                        <div id = "msg_notification">
                            <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                <span style="flex-grow: 1;">{{ Session::get('success') }}</span>
                                <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                            </div>
                            <br>
                        </div>
                    @endif

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
                    
                <form method = "post" action = "{{ route('adding_product') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                    <div class="card-header">
                        <h4>Add Product</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input style="font-weight: 600;" type="text" class="form-control" value="{{ old('product_name') }}" name="product_name" placeholder="Enter product name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Title</label>
                                    <input style="font-weight: 600;" type="text" class="form-control" value="{{ old('product_title') }}" name="product_title" placeholder="Enter product title" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea style="font-weight: 600;" class="form-control" name="product_description" value="{{ old('product_description') }}" placeholder="Enter product description" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Price Without Discount</label>
                                    <input style="font-weight: 600;" min = "1" type="number" class="form-control" name="price_without_discount" value="{{ old('price_without_discount') }}" placeholder="Product price without discount" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Price With Discount</label>
                                    <input style="font-weight: 600;" min = "1" type="number" class="form-control" name="price_with_discount" value="{{ old('price_with_discount') }}" placeholder="Product price with discount" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Product Quantity</label>
                                    <input style="font-weight: 600;" min = "1" type="number" class="form-control" name="product_quantity" value="{{ old('product_quantity') }}" placeholder="Product Quantity" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Product Thumbnail Image</label>
                                <div class="custom-file">
                                    <input type="file" style="font-weight: 600;" class="custom-file-input" name="thumbnail_image" id="thumbnail_image_tag" style = "cursor : pointer;" required>
                                    <label class="custom-file-label" for="profile_pic">Choose image</label>
                                    <div id="fileName1" style = "margin-top : 1rem; font-weight : 600;"></div>
                                </div>
                                <div id="size-error-message" style="display : none; font-size : 1rem; text-align : center; color: red; margin-top : 1rem; margin-bottom : 0.5rem; font-weight : 600;">Image dimensions is too high, please reduse image height/width !</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Other Images [Multiple images allowed]</label>
                                <div class="custom-file">
                                    <input type="file" style="font-weight: 600;" class="custom-file-input" multiple name="other_images[]" id="other_image_tag" style = "cursor : pointer;" required>
                                    <label class="custom-file-label" for="profile_pic">Choose images</label>
                                    <div id="fileNameA" style = "margin-top : 1rem; font-weight : 600;"></div>
                                    <div id="file-error-message" style="font-size : 1rem; color: red; display: none; margin-top : 1rem; font-weight : 600;">You can upload a maximum of 3 images!</div>
                                </div>
                                <div id="size-error2" style="display : none; font-size : 1rem; text-align : center; color: red; margin-top : 1rem; margin-bottom : 0.5rem; font-weight : 600;">Image dimensions is too high, please reduse image height/width !</div>
                            </div>
                        </div>
 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event Name</label>
                                    <select style = "font-weight : 600;" class="form-control star-rating" name="event_id" id = "event_id" required>
                                        <option value = "" style = "text-align : center;" selected disabled>-- &nbsp; Select Event &nbsp; --</option>
                                            @if(isset($allEvents))
                                                @if(count($allEvents) > 0)
                                                    @foreach($allEvents as $event)
                                                        <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                                                    @endforeach
                                                @endif
                                            @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub-event Name</label>
                                    <select style = "font-weight : 600;" class="form-control star-rating" name="sub_event_id" id = "sub_event_id" required>
                                        <option value = "" style = "text-align : center;" selected disabled>-- &nbsp; Select Sub-event &nbsp; --</option>
                                            
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Add Product</button>
                    </div>
                    </div>
                </form>
            </div>
      </div>
    </section>
</div>

<script>
    document.getElementById('other_image_tag').addEventListener('change', function() {
        var fileInput = this;
        var fileErrorMessage = document.getElementById('file-error-message');
        var bijo = document.getElementById('fileNameA');
        var maxFiles = 3;

        if (fileInput.files.length > maxFiles) {
            fileErrorMessage.style.display = 'block';
            fileInput.value = '';
            bijo.style.display = 'none';
        } else {
            fileErrorMessage.style.display = 'none';
        }
    });
</script>


<script>

    function showFileName1(input) {
        var fileNameElement = document.getElementById('fileName1');
        if (input.files && input.files.length > 0) {
            var filename = input.files[0].name;
            var extensionIndex = filename.lastIndexOf('.');
            var filenameWithoutExtension = filename.substring(0, extensionIndex);
            var extension = filename.substring(extensionIndex + 1);
            var displayedName;
            if (filenameWithoutExtension.length > 35) {
                var firstPart = filenameWithoutExtension.substring(0, 35);
                var lastPart = filenameWithoutExtension.substring(filenameWithoutExtension.length - 10);
                displayedName = firstPart + '.....' + lastPart;
            } else {
                displayedName = filenameWithoutExtension;
            }
            fileNameElement.innerHTML = 'Selected File : "' + displayedName + '.' + extension + '"';

            let hehepop = document.getElementById("size-error-message");
            hehepop.style.display = "none";
        } else {
            fileNameElement.innerHTML = '';
        }
    }

    function showFileNameA(input) {
        var fileNameElement = document.getElementById('fileNameA');
        if (input.files && input.files.length > 0) {
            var totalFiles = input.files.length;
            fileNameElement.innerHTML = 'Total Files Selected : ' + totalFiles;

            let hehepop = document.getElementById("size-error2");
            hehepop.style.display = "none";
        } else {
            fileNameElement.innerHTML = '';
        }
    }

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
                                let dekhado = document.getElementById('size-error-message');

                                dekhado.style.display = 'block';
                               
                                input.value = ''; 
                            } else {
                                showFileName1(input);
                            }
                        }
                    };
                })(i); 

                img.src = URL.createObjectURL(image);
            }
        }
    }

    function validateImages2(input) {
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
                                let dekhado = document.getElementById('size-error2');
                                dekhado.style.display = 'block';
                                input.value = ''; 
                            } else {
                                showFileNameA(input);
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
        validateImages2(event.target);
    });

    document.addEventListener("DOMContentLoaded", function () {
        var eventId = document.getElementById('event_id').value;
        var subEventSelect = document.getElementById('sub_event_id');

        if (eventId === '') 
        {
            var option = document.createElement('option');
            option.textContent = "Please select any event first";
            option.disabled = true;
            subEventSelect.appendChild(option);
        }
    });

    function populateSubEvents() {
        var eventId = document.getElementById('event_id').value;
        var subEventSelect = document.getElementById('sub_event_id');
        subEventSelect.innerHTML = '';

        console.log(eventId);

        @foreach($allEvents as $event)
            if ({{ $event->id }} == eventId) 
            {
            
                var option1 = document.createElement('option');
                option1.textContent = "-- Select Sub-event --";
                option1.disabled = true;
                option1.selected = true;
                option1.value = "";
                option1.style.textAlign = 'center';
                subEventSelect.appendChild(option1);

                @if(count($event->subEvents) > 0)
                    @foreach($event->subEvents as $subEvent)
                        var option = document.createElement('option');
                        option.value = "{{ $subEvent->id }}";
                        option.textContent = "{{ $subEvent->sub_event_name }}";
                        subEventSelect.appendChild(option);
                    @endforeach
                @else
                    var option = document.createElement('option');
                    option.textContent = "No sub-event added";
                    subEventSelect.appendChild(option);
                @endif
            }
        @endforeach

    }

    document.getElementById('event_id').addEventListener('change', populateSubEvents);
</script>
@endsection

@section('script')
  <script>
    let Products = document.getElementById("Products");
    Products.classList.add("active");
  </script>
@endsection