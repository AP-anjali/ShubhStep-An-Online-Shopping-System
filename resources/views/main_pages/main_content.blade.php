<main>

    <!--
      - BANNER
    -->

    <div class="banner">

      <div class="container" id="container">

        <div class="slider-container has-scrollbar" id="slider-container">

          <div class="slider-item">

            <img src="./assets/images/banner/1.png" alt="women's latest fashion sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Trending items</p>

              <h2 class="banner-title">DISCOVER THE BEST DEALS</h2>

              <p class="banner-text">
                Find Your Perfect Fit
              </p>

              <a onclick = "let successScroll = document.getElementById('successScroll');
                    successScroll.scrollIntoView({ behavior: 'smooth' });" style = "cursor : pointer;" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="./assets/images/banner/2.png" alt="modern sunglasses" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Safe Payments</p>

              <h2 class="banner-title">SECURE <br>& RELIABLE Transactions</h2>

              <p class="banner-text">
                By Razorpay Gateway
              </p>

              <a onclick = "let successScroll = document.getElementById('successScroll');
                    successScroll.scrollIntoView({ behavior: 'smooth' });" style = "cursor : pointer;" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="./assets/images/banner/3.png" alt="new fashion summer sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">More Reliability</p>

              <h2 class="banner-title">PAY AT YOUR DOORstep</h2>

              <p class="banner-text">
                Cash Payment On Delivery
              </p>

              <a onclick = "let successScroll = document.getElementById('successScroll');
                    successScroll.scrollIntoView({ behavior: 'smooth' });" style = "cursor : pointer;" class="banner-btn">Shop now</a>

            </div>

          </div>

        </div>
      
        <div id = "successScroll"></div>

      </div>

    </div>


    <!--
      - PRODUCT
    -->

    <div class="product-container">

      <div class="container">


        <!--
          - SIDEBAR
        -->

        <div class="sidebar  has-scrollbar" data-mobile-menu>

          <div class="sidebar-category">

            <div class="sidebar-top">
              <h2 class="sidebar-title">Events</h2>

              <button class="sidebar-close-btn" data-mobile-menu-close-btn>
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

                          @if($eachProduct->product_quantity > 0)
                              <div class="showcase-rating" style = "color : #006400; font-weight : 500;">
                                  <i class="fa-solid fa-circle-check"></i>&nbsp; In stock
                              </div>
                          @endif
                          
                          @if($eachProduct->product_quantity <= 0)
                              <div class="showcase-rating" style = "color : #ab0023; font-weight : 500;">
                                  <i class="fa-solid fa-circle-xmark"></i>&nbsp; Out of stock
                              </div>
                          @endif

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

        <div class="product-box">

          <!--
            - PRODUCT GRID
          -->

          <div class="product-main">

            <h2 class="title" id = "forScollPosition">All Products</h2> 

            <div class="header-search-container"  style = "margin-bottom : 1rem;">

              <input type="search" id="searchBox2" name="search" class="search-field" oninput="filterproducts()" placeholder="Search product here...">

              <button class="search-btn" onclick = "filterproducts()">
                <ion-icon name="search-outline"></ion-icon>
              </button>

            </div>

            <h1 id = "noDataMessage2"></h1>
            
            @if (Session::has('success'))
              <div  id = "msg_notification">
                <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                  <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                  <span style="flex-grow: 1;">{{ Session::get('success') }}</span>
                  <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                </div><br>
              </div>

              <script>
                window.onload = function() {
                    let successScroll = document.getElementById('successScroll');
                    successScroll.scrollIntoView({ behavior: 'smooth' });
                };
              </script>
            @endif

            @if (Session::has('MySession'))
              <script>
                window.onload = function() {
                    let successScroll = document.getElementById('successScroll');
                    successScroll.scrollIntoView({ behavior: 'smooth' });
                };
              </script>
            @endif


            @if(isset($allProducts))
              @if(count($allProducts) > 0)
                <div class="product-grid">
                    @foreach($allProducts as $eachProduct)
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

                          <a onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'" style = "cursor : pointer;" class="showcase-category seachProductName">{{ $eachProduct->product_name }}</a>

                          <a onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'" style = "cursor : pointer;">
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
                                  <img src="./assets/images/pic-1.jpg" alt="wishlist image" width="400" height="460">
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
                                <img src="./assets/images/pic-2.jpg" alt="cart image" width="400" height="410">
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

                                  <input type="number" min = "1" value = "1" name="quantity" class="email-field" placeholder="Quantity" required>

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
                                <img src="./assets/images/pic-3.png" alt="buy now image" width="400" height="440">
                              </div>

                              <div class="newsletter">

                                <form action="{{ route('buy_now') }}" method = "post" id="buy-now-form">

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

                                  <input type="number" min="1" value = "1" name="quantity" class="email-field" placeholder="Quantity" required>

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

        </div>

      </div>

    </div>

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


    <!--
      - TESTIMONIALS, CTA & SERVICE
    -->

    @include('main_pages.TESTIMONIALS')

  </main>