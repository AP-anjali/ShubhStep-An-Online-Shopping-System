<main>

    <!--
      - PRODUCT
    -->

    <div class="product-container">

      <div class="container">


        <!--
          - SIDEBAR
        -->

        <div id = "EventSidebar" class="sidebar  has-scrollbar" style = "display : none;" data-mobile-menu>

          <div class="sidebar-category">

            <div class="sidebar-top">
              <h2 class="sidebar-title">Events</h2>

              <button class="sidebar-close-btn" onclick = "closeEventSidebar()" data-mobile-menu-close-btn>
                <ion-icon name="close-outline"></ion-icon>
              </button>
            </div>

            <ul class="sidebar-menu-category-list">

              @if(isset($allEvents))
                @if(count($allEvents) > 0)
                  @foreach($allEvents as $eachEvent)
                    <li class="sidebar-menu-category">

                      <button class="sidebar-accordion-menu" data-accordion-btn>

                          <!-- <img src="./assets/images/icons/dress.svg" alt="clothes" width="20" height="20"
                            class="menu-title-img"> -->

                            @if($eachEvent->subEvents->isNotEmpty())
                              <div class="menu-title-flex">
                                <span style = "color : #8789ff;"><i class="fa-solid fa-circle-check"></i></span>
                                <p class="menu-title">{{ $eachEvent->event_name }}</p>
                              </div>

                              <div>
                                <ion-icon name="add-outline" class="add-icon"></ion-icon>
                                <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                              </div>
                            @else
                              <div class="menu-title-flex">
                                <span style = "color : #8789ff;"><i class="fa-solid fa-circle-check"></i></span>
                                <a href = "#" class="menu-title">{{ $eachEvent->event_name }}</a>
                              </div>
                            @endif

                      </button>

                      @if($eachEvent->subEvents->isNotEmpty())
                        <ul class="sidebar-submenu-category-list" data-accordion>

                          @foreach($eachEvent->subEvents as $subEvent)
                            <li class="sidebar-submenu-category">
                              <a style = "cursor : pointer;" onclick = "window.location.href = '/Event/{{$subEvent->event->event_name}}/{{$subEvent->sub_event_name}}/{{$subEvent->id}}'" class="sidebar-submenu-title">
                                <p class="product-name">{{ $subEvent->sub_event_name }}</p>
                              </a>
                            </li>
                          @endforeach
                      
                        </ul>
                      @endif

                    </li>
                  @endforeach
                @else
                  <h4 class="showcase-title" style = "text-align : center;">No any event added yet !</h4>
                @endif
              @endif

            </ul>

          </div>

          <div class="product-showcase">

            <h3 class="showcase-heading">Most sold products</h3>

            <div class="showcase-wrapper">

              <div class="showcase-container">

                @if(isset($topSoldProducts))
                  @if(count($topSoldProducts) > 0)
                    @foreach($topSoldProducts as $eachProduct)
                      <div class="showcase">

                        <a style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'" class="showcase-img-box">
                          <img src="{{ asset('storage/' . $eachProduct->thumbnail_image ) }}" alt="product main img" width="70" height="75"
                            class="showcase-img">
                        </a>

                        <div class="showcase-content">

                          <a style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'">
                            <h4 class="showcase-title">{{ $eachProduct->product_name }}</h4>
                          </a>

                          <div class="showcase-rating">
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                          </div>

                          <div class="price-box">
                            <del><i class="fa-solid fa-indian-rupee-sign"></i> {{ $eachProduct->price_without_discount }}</del>
                            <p class="price"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $eachProduct->price_with_discount }}</p>
                          </div>

                        </div>

                      </div>
                    @endforeach
                  @else
                    <h4 class="showcase-title" style = "text-align : center;">No any product uploaded yet !</h4>
                    <!-- <div style = "font-size : 16px; color : #343434; width : text-align : center; "><b><i>There is no any data to show !</i></b></div> -->
                  @endif
                @endif

              </div>

            </div>

          </div>

        </div>



        <div class="product-box" style = "width : 100%;">

          <!--
            - PRODUCT GRID
          -->

          <div class="product-featured" style = "margin-top : 1%;">

            <h2 class="title" style = "border-top: 1px solid hsl(0, 0%, 93%); padding-top: 0.5rem;" >{{ $product_data->product_title }}</h2>
            
            @if (Session::has('success'))
              <div  id = "msg_notification">
                <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                  <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                  <span style="flex-grow: 1;">{{ Session::get('success') }}</span>
                  <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                </div><br>
              </div>
            @endif


            <div class="showcase-wrapper has-scrollbar">

              <div class="showcase-container">

                <div class="showcase">

                  <div class="showcase-banner" style="text-align: center; width : 100%; display: flex; align-items: center; justify-content: center;">
                    <img id="main-image" src="{{ asset('storage/' . $product_data->thumbnail_image ) }}" style = "cursor : pointer; object-fit: contain; min-height: 320px; max-height: 400px;" width = "100%" alt="product img" class="showcase-img">
                  </div>
                  

                  <div class="showcase-content">

                    <div style = "height : 5rem; display : flex; margin-bottom: 0.7rem; text-align: center; align-items: center; justify-content: center;">

                        <img src="{{ asset('storage/' . $product_data->thumbnail_image ) }}" id = "jsdhfjsdfh" class="showcase-img thumbnail-img maroPhoto">

                        @if(is_array($product_data->other_images) && count($product_data->other_images) > 0)
                            @foreach($product_data->other_images as $img)
                                <img src = "{{ asset('storage/' . $img) }}" class="showcase-img thumbnail-img maroPhoto djfheuyru">
                            @endforeach
                        @endif
                    </div><hr style = "margin-bottom : 0.3rem;">

                    <a onclick = "window.location.reload();" style = "cursor : pointer;">
                      <h3 class="showcase-title">{{ $product_data->product_title }}</h3>
                    </a>

                    @if($product_data->product_quantity > 0)
                        <div class="showcase-rating" style = "color : #006400; font-weight : 500;">
                            <i class="fa-solid fa-circle-check"></i>&nbsp; In stock
                        </div>
                    @endif
                    
                    @if($product_data->product_quantity <= 0)
                        <div class="showcase-rating" style = "color : #ab0023; font-weight : 500;">
                            <i class="fa-solid fa-circle-xmark"></i>&nbsp; Out of stock
                        </div>
                    @endif

                    <p class="showcase-desc" style = "font-weight : 500;">
                        {{ $product_data->product_description }}
                    </p>

                    <div class="price-box">
                      <p class="price"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $product_data->price_with_discount }}/-</p>

                      <del>{{ $product_data->price_without_discount }}</del>
                    </div>

                    <h3 class="showcase-title" style = "margin-top : 5%; color : #454545;">Ordered quantity : {{ $quantity }}</h3>

                    <h3 class="showcase-title" style = "margin-top : 2%; color : #8789ff;">Total Amount : </h3>

                    <div style="display: flex; gap: 5%; text-align: center; align-items: center; justify-content: center; margin-top: 1%;">

                        <h3 class="showcase-desc" style="color: #454545; font-size : 0.9rem; font-weight : 650; text-transform: uppercase;">Without discount : <span style="color: #E10600;"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $totalAmountWithoutDiscount }}/-</span></h3>
                        <h3 class="showcase-desc" style="color: #454545; font-size : 0.9rem; font-weight : 650; text-transform: uppercase;">With discount : <span style="color: #006400;"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $totalAmountWithDiscount }}/-</span></h3>

                    </div>

                    <div style = "display : flex; gap : 5%; padding : 0; text-align : center; align-items : center; justify-content: center; margin-top : 5%;">

                        <button class="add-cart-btn" id="rzp-button">Online Payment</button>
                        <button class="add-cart-btn" id="cashOnDelivery-button">Cash on delivery</button>
                        <button class="add-cart-btn" onclick = "window.location.href = '/'">Exit</button>

                    </div>

                      <form method = "post" action = "{{ route('payment_of_single_product') }}" style = "display : none;" id="payment-form">
                          @csrf

                          <input type="hidden" id="product_id" name="product_id" value="{{ $product_data->id }}">
                          <input type="hidden" id="product_quantity" name="product_quantity" value="{{ $quantity }}">
                          <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id">

                          @if(isset($cartRecordID))
                            <input type="hidden" name="fromCart" value = "1">
                            <input type="hidden" name="cartRecordID" value = "{{ $cartRecordID }}">
                          @endif
                      </form>

                      <form method = "post" action = "{{ route('payment_of_single_product_COD') }}" style = "display : none;" id = "cashOnDeliveryForm">
                          @csrf

                          <input type="hidden" id="product_id" name="product_id" value="{{ $product_data->id }}">
                          <input type="hidden" id="product_quantity" name="product_quantity" value="{{ $quantity }}">

                          @if(isset($cartRecordID))
                            <input type="hidden" name="fromCart" value = "1">
                            <input type="hidden" name="cartRecordID" value = "{{ $cartRecordID }}">
                          @endif

                      </form>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div id="lightbox" class="lightbox">
              <span class="close">&times;</span>
              <div class="lightbox-content-container">
                  <img class="lightbox-content">
              </div>
              <div class="lightbox-thumbnails">
                  <!-- Thumbnails will be added dynamically -->
              </div>
              <a class="prev">&#10094;</a>
              <a class="next">&#10095;</a>
          </div>

          <!-- --------------- Other Products section [start] ----------------- -->
          <div class="product-main">

            <h2 class="title" style = "border-top: 1px solid hsl(0, 0%, 93%); padding-top: 0.5rem;" id = "forScollPosition">Other Products</h2> 

            <div class="header-search-container"  style = "margin-bottom : 1rem;">

              <input type="search" id="searchBox2" name="search" class="search-field" oninput="filterproducts()" placeholder="Search product here...">

              <button class="search-btn" onclick = "filterproducts()">
                <ion-icon name="search-outline"></ion-icon>
              </button>

            </div>

            <h1 id = "noDataMessage2"></h1>

            @if(isset($other_product_data))
              @if(count($other_product_data) > 0)
                <div class="product-grid">
                    @foreach($other_product_data as $eachProduct)
                      <div class="showcase class_for_search_box">

                        <div class="showcase-banner">

                          <img src="{{ asset('storage/' . $eachProduct->thumbnail_image ) }}" alt="main img" width="310" style = "min-height : 280px;" class="product-img default">
                          
                          
                          @if(is_array($eachProduct->other_images) && count($eachProduct->other_images) > 0)
                              <img src="{{ asset('storage/' . $eachProduct->other_images[0]) }}" alt="other img" width="310" style="min-height: 280px;" class="product-img hover">
                          @endif

                          <div class="showcase-actions">

                            <button class="btn-action" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'">
                              <ion-icon name="eye-outline"></ion-icon>
                            </button>

                            @if(isset($userWishlistProducts))
                              @if(in_array($eachProduct->id, $userWishlistProducts))
                                  <button onclick = "window.location.href = '/customer-wishlist'" class="btn-action">
                                    <ion-icon name="heart" aria-label="Favorite"></ion-icon>
                                  </button>
                              @else
                                  <button onclick = "openWhishlist({{ $loop->index }})" class="btn-action">
                                    <ion-icon name="heart-outline"></ion-icon>
                                  </button>
                              @endif
                            @else
                                <button onclick = "openWhishlist({{ $loop->index }})" class="btn-action">
                                  <ion-icon name="heart-outline"></ion-icon>
                                </button>
                            @endif

                            @if(isset($userCartProducts))
                              @if(in_array($eachProduct->id, $userCartProducts))
                                <button onclick = "window.location.href = '/customer-cart'" class="btn-action">
                                  <ion-icon name="cart"></ion-icon>
                                </button>
                              @else
                                <button onclick = "openCart({{ $loop->index }})" class="btn-action">
                                  <ion-icon name="cart-outline"></ion-icon>
                                </button>
                              @endif
                            @else
                              <button onclick = "openCart({{ $loop->index }})" class="btn-action">
                                <ion-icon name="cart-outline"></ion-icon>
                              </button>
                            @endif

                            <button onclick = "openBuyNow({{ $loop->index }})" class="btn-action">
                              <ion-icon name="wallet-outline"></ion-icon>
                            </button>

                          </div> 
                                                 
                        </div>                  

                        <div class="showcase-content">

                          <a href="#" class="showcase-category seachProductName">{{ $eachProduct->product_name }}</a>

                          <a href="#">
                            <h3 class="showcase-title seachProductTitle">{{ $eachProduct->product_title }}</h3>
                          </a>

                          @if($eachProduct->product_quantity > 0)
                              <div class="showcase-rating" style = "color : #006400; font-weight : 500; font-size : 0.9rem;">
                                  <i class="fa-solid fa-circle-check"></i>&nbsp; In stock
                              </div>
                          @endif
                          
                          @if($eachProduct->product_quantity <= 0)
                              <div class="showcase-rating" style = "color : #ab0023; font-weight : 500; font-size : 0.9rem;">
                                  <i class="fa-solid fa-circle-xmark"></i>&nbsp; Out of stock
                              </div>
                          @endif

                          <div class="price-box">
                            <p class="price" style = "white-space : nowrap; "><i class="fa-solid fa-indian-rupee-sign"></i> {{ $eachProduct->price_with_discount }}</p>
                            <del style = "white-space : nowrap; "><i class="fa-solid fa-indian-rupee-sign"></i> {{ $eachProduct->price_without_discount }}</del>
                          </div>

                          <!-- <div class="price-box">
                              <p class="price"><i class="fa-solid fa-indian-rupee-sign"></i> {{ number_format($eachProduct->price_with_discount, 0, '.', '') }}</p>
                              <del><i class="fa-solid fa-indian-rupee-sign"></i> {{ number_format($eachProduct->price_without_discount, 0, '.', '') }}</del>
                          </div> -->

                          <div class="showcase-actions2">

                            <button class="btn-action2" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'">
                              <ion-icon name="eye-outline"></ion-icon>
                            </button>

                            @if(isset($userWishlistProducts))
                              @if(in_array($eachProduct->id, $userWishlistProducts))
                                  <button onclick = "window.location.href = '/customer-wishlist'" class="btn-action2">
                                    <ion-icon name="heart" aria-label="Favorite"></ion-icon>
                                  </button>
                              @else
                                  <button onclick = "openWhishlist({{ $loop->index }})" class="btn-action2">
                                    <ion-icon name="heart-outline"></ion-icon>
                                  </button>
                              @endif
                            @else
                                <button onclick = "openWhishlist({{ $loop->index }})" class="btn-action2">
                                  <ion-icon name="heart-outline"></ion-icon>
                                </button>
                            @endif

                            @if(isset($userCartProducts))
                              @if(in_array($eachProduct->id, $userCartProducts))
                                <button onclick = "window.location.href = '/customer-cart'" class="btn-action2">
                                  <ion-icon name="cart"></ion-icon>
                                </button>
                              @else
                                <button onclick = "openCart({{ $loop->index }})" class="btn-action2">
                                  <ion-icon name="cart-outline"></ion-icon>
                                </button>
                              @endif
                            @else
                              <button onclick = "openCart({{ $loop->index }})" class="btn-action2">
                                <ion-icon name="cart-outline"></ion-icon>
                              </button>
                            @endif

                              <button onclick = "openBuyNow({{ $loop->index }})" class="btn-action2">
                                <ion-icon name="wallet-outline"></ion-icon>
                              </button>

                          </div>

                        </div>
                      </div>

                        <div class="modal closed" id="wishlist_pop_up_{{ $loop->index }}" data-modal>

                            <div class="modal-close-overlay" data-modal-overlay></div>

                              <div class="modal-content">

                                <button class="modal-close-btn" data-modal-close>
                                  <ion-icon name="close-outline"></ion-icon>
                                </button>

                                <div class="newsletter-img">
                                  <img src="{{ asset('img/pic-1.jpg') }}" alt="wishlist image" width="400" height="460">
                                </div>

                                <div class="newsletter">

                                  <form action="{{ route('add_to_wishlist') }}" method = "post">
                                    @csrf

                                    <input type="hidden" name="product_id" value = "{{ $eachProduct->id }}">

                                    @if(isset($customer_session))
                                      <input type="hidden" name="customer_id" value = "{{ $customer_session->id }}">
                                    @endif

                                    <div class="newsletter-header" style = "text-align : center;">

                                      <h3 class="newsletter-title" style = "text-align : center;">Add product to wishlist</h3>

                                      <p class="newsletter-desc" style = "text-align : center;">
                                        Are you sure to Add this product in wishlist for buy <span style = "white-space : nowrap;">later ?</span>
                                      </p>

                                    </div>

                                    <button type="submit" class="btn-newsletter">Add to wishlist</button><br>

                                    <p class="newsletter-desc" style = "text-align : center; font-weight : 600;">
                                      Thank you, Enjoy the <span style = "white-space : nowrap;">shopping !</span>
                                    </p>

                                  </form>

                                </div>

                              </div>

                        </div>

                        <div class="modal closed" id="cart_pop_up_{{ $loop->index }}" data-modal2>

                            <div class="modal-close-overlay" data-modal-overlay2></div>

                            <div class="modal-content">

                              <button class="modal-close-btn" data-modal-close2>
                                <ion-icon name="close-outline"></ion-icon>
                              </button>

                              <div class="newsletter-img">
                                <img src="{{ asset('img/pic-2.jpg') }}" alt="cart image" width="400" height="410">
                              </div>

                              <div class="newsletter">

                                <form action="{{ route('add_to_cart') }}" method = "post">

                                  @csrf

                                    <input type="hidden" name="product_id" value = "{{ $eachProduct->id }}">
                                    <input type="hidden" name="product_price_without_discount" value = "{{ $eachProduct->price_without_discount }}">
                                    <input type="hidden" name="product_price_with_discount" value = "{{ $eachProduct->price_with_discount }}">

                                    @if(isset($customer_session))
                                      <input type="hidden" name="customer_id" value = "{{ $customer_session->id }}">
                                    @endif

                                  <div class="newsletter-header">

                                    <h3 class="newsletter-title" style = "text-align : center;">Add product to cart</h3>

                                    <p class="newsletter-desc" style = "text-align : center;">
                                      Add product to cart for buy later...!
                                    </p>

                                    <p class="newsletter-desc" style = "text-align : center; font-weight : 600;">
                                      Thank you, Enjoy shopping !
                                    </p>

                                  </div>

                                  <input type="number" min = "1" name="quantity" class="email-field" placeholder="Quantity" required>

                                  <button type="submit" class="btn-newsletter">Add To Cart</button>
                                </form>

                              </div>

                            </div>

                        </div>

                        <div class="modal closed" id="buy_now_pop_up_{{ $loop->index }}" data-modal3>

                            <div class="modal-close-overlay" data-modal-overlay3></div>

                            <div class="modal-content">

                              <button class="modal-close-btn" data-modal-close3>
                                <ion-icon name="close-outline"></ion-icon>
                              </button>

                              <div class="newsletter-img">
                                <img src="{{ asset('img/pic-3.png') }}" alt="buy now image" width="400" height="440">
                              </div>

                              <div class="newsletter">

                                <form action="{{ route('buy_now') }}" method = "post">

                                  @csrf

                                    <input type="hidden" name="product_id" value = "{{ $eachProduct->id }}">
                                    <input type="hidden" name="product_price_without_discount" value = "{{ $eachProduct->price_without_discount }}">
                                    <input type="hidden" name="product_price_with_discount" value = "{{ $eachProduct->price_with_discount }}">

                                    @if(isset($customer_session))
                                      <input type="hidden" name="customer_id" value = "{{ $customer_session->id }}">
                                    @endif

                                  <div class="newsletter-header">

                                    <h3 class="newsletter-title" style = "text-align : center;">Select product for buy now</h3>

                                    <p class="newsletter-desc" style = "text-align : center;">
                                      Select this product for <span style = "white-space : nowrap;">buy now</span>
                                    </p>

                                    <p class="newsletter-desc" style = "text-align : center; font-weight : 600;">
                                      Thank you, Enjoy shopping !
                                    </p>

                                  </div>

                                  <input type="number" min = "1" name="quantity" class="email-field" placeholder="Quantity" required>

                                  @if(isset($address_stored))
                                      @if($address_stored && $customer_session->phone_no !== NULL)
                                          <button type="submit" class="btn-newsletter">Buy Now</button>
                                      @else
                                          @if($address_stored && $customer_session->phone_no === NULL)
                                              <button type="button" onclick="window.location.href='{{ route('go_to_register_only_phone_number') }}'" class="btn-newsletter">Buy Now</button>
                                          @elseif(!$address_stored && $customer_session->phone_no !== NULL)
                                              <button type="button" onclick="window.location.href='{{ route('go_to_register_address') }}'" class="btn-newsletter">Buy Now</button>
                                          @elseif(!$address_stored && $customer_session->phone_no === NULL)
                                              <button type="button" onclick="window.location.href='{{ route('both') }}'" class="btn-newsletter">Buy Now</button>
                                          @endif
                                      @endif
                                  @else
                                      <button type="submit" class="btn-newsletter">Buy Now</button>
                                  @endif

                                </form>

                              </div>

                            </div>

                        </div> 
                    @endforeach
                </div>
              @else
            <h3 class="showcase-heading" style = "color : hsl(0, 0%, 27%); text-align : center;">No any product uploaded yet !</h3>
              @endif
            @endif

          </div>
          <!-- --------------- Other Products section [end] ----------------- -->

          </div>

        </div>

      </div>

    </div>

  </main>

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script>

        var totalAmountWithDiscount = {{ $totalAmountWithDiscount }};

        document.getElementById('rzp-button').onclick = function (e) {

          console.log("Razorpay API Key:", "{{ env('RAZORPAY_API_KEY') }}");

            var amountInPaise = totalAmountWithDiscount * 100;

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

        document.getElementById('cashOnDelivery-button').onclick = function (e) 
        {
            e.preventDefault();

            let cashOnDeliveryForm = document.getElementById('cashOnDeliveryForm');

                swal({
                title: 'Are you sure?',
                text: 'Are you sure to buy this product by cash-on-delivery payment method !',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
                className: 'custom-swal'
                })
                .then((willDelete) => {
                    if (willDelete) {
                      cashOnDeliveryForm.submit();
                    }
                });
        }
    </script>

  <script>

        var noDataMessage2 = document.getElementById('noDataMessage2');
        noDataMessage2.style.display = "none";

        function filterproducts() 
        {
            var input2, filter2, productContainer, productName, productBrand, j;
            input2 = document.getElementById('searchBox2');
            filter2 = input2.value.toUpperCase();
            productContainer = document.querySelectorAll('.class_for_search_box');
            var matchingProductsExist = false; 

            for (j = 0; j < productContainer.length; j++) {
                productName = productContainer[j].querySelector(".seachProductName").textContent.toUpperCase();
                productBrand = productContainer[j].querySelector(".seachProductTitle").textContent.toUpperCase();
                
                if (productName.indexOf(filter2) > -1 || productBrand.indexOf(filter2) > -1) {
                    productContainer[j].style.display = "";
                    matchingProductsExist = true; 
                } else {
                    productContainer[j].style.display = "none";
                }
            }

            if (!matchingProductsExist) {
                if (noDataMessage2) {
                    noDataMessage2.style.display = "block";
                    noDataMessage2.innerText = 'Sorry, no data available for "' + input2.value + '"';
                }

                if((productContainer.length) <= 0)
                {
                  noDataMessage2.style.display = "none";
                }
            } else {
                if (noDataMessage2) {
                    noDataMessage2.style.display = "none";
                }
            }
        }

        function filterproducts2() 
        {
            var input2, filter2, productContainer, productName, productBrand, j;
            input2 = document.getElementById('searchBox');
            filter2 = input2.value.toUpperCase();
            productContainer = document.querySelectorAll('.class_for_search_box');
            var matchingProductsExist = false; 

            for (j = 0; j < productContainer.length; j++) {
                productName = productContainer[j].querySelector(".seachProductName").textContent.toUpperCase();
                productBrand = productContainer[j].querySelector(".seachProductTitle").textContent.toUpperCase();
                
                if (productName.indexOf(filter2) > -1 || productBrand.indexOf(filter2) > -1) {
                    productContainer[j].style.display = "";
                    matchingProductsExist = true; 
                } else {
                    productContainer[j].style.display = "none";
                }
            }

            if (!matchingProductsExist) {
                if (noDataMessage2) {
                    noDataMessage2.style.display = "block";
                    noDataMessage2.innerText = 'Sorry, no data available for "' + input2.value + '"';
                }

                if((productContainer.length) <= 0)
                {
                  noDataMessage2.style.display = "none";
                }
            } else {
                if (noDataMessage2) {
                    noDataMessage2.style.display = "none";
                }
            }

            const forScollPosition = document.getElementById('forScollPosition');
            forScollPosition.scrollIntoView({ behavior: 'smooth' });
        }

        function filterproducts3() 
        {
            var input2, filter2, productContainer, productName, productBrand, j;
            input2 = document.getElementById('searchBox');
            filter2 = input2.value.toUpperCase();
            productContainer = document.querySelectorAll('.class_for_search_box');
            var matchingProductsExist = false; 

            for (j = 0; j < productContainer.length; j++) {
                productName = productContainer[j].querySelector(".seachProductName").textContent.toUpperCase();
                productBrand = productContainer[j].querySelector(".seachProductTitle").textContent.toUpperCase();
                
                if (productName.indexOf(filter2) > -1 || productBrand.indexOf(filter2) > -1) {
                    productContainer[j].style.display = "";
                    matchingProductsExist = true;
                } else {
                    productContainer[j].style.display = "none";
                }
            }

            if (!matchingProductsExist) {
                if (noDataMessage2) {
                    noDataMessage2.style.display = "block";
                    noDataMessage2.innerText = 'Sorry, no data available for "' + input2.value + '"';
                }

                if((productContainer.length) <= 0)
                {
                  noDataMessage2.style.display = "none";
                }
            } else {
                if (noDataMessage2) {
                    noDataMessage2.style.display = "none";
                }
            }
        }
    </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const thumbnails = document.querySelectorAll(".thumbnail-img");
        const mainImage = document.getElementById("main-image");

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener("click", function() {
                mainImage.src = thumbnail.src;

                thumbnails.forEach(thumb => {
                    thumb.style.border = "2px solid #454545";
                });

                thumbnail.style.border = "2px solid #8789ff";
            });
        });
    });
</script>