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

              <a href = "/redirect-route" class="banner-btn">Shop now</a>

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

              <a href = "/redirect-route" class="banner-btn">Shop now</a>

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

              <a href = "/redirect-route" class="banner-btn">Shop now</a>

            </div>

          </div>

        </div>
      
      </div>

        <div id = "successScroll"></div>              

    </div>
    
    <div class="product-container">


        <div class="container">

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
                <section class="hero_anjali">
                    <div class="heading_anjali">
                        <h1>About Us</h1>
                    </div>
                    <div class="container_anjalipatel">
                        <div class="hero-content_anjali">
                            <h2>Welcome To Our Website !</h2>
                            <p>We are delighted to offer a wide range of event decoration products for all your special occasions. Whether you are planning a wedding or engagement, Holi celebration, birthday party or any other event, we have everything you need to create a memorable and beautiful atmosphere. Explore our website to discover the perfect decorations for your next celebration !</p>
                            <button type = "button" onclick = "window.location.href = '/terms-and-conditions'" class = "cta_anjali_btn">Read More</button>
                        </div>
                        <div class="hero-image_anjali_patel">
                            <img src="./assets/images/logo/logo.png" id = "ab_pic" alt="About us img">
                        </div>
                    </div>
                </section>

                <hr id = "redirecting_div" style = "margin : 2rem 0;">

                <div class="section_anjali16">
                    <div class="title_anjali16">
                        <h1>Our Services</h1>
                    </div>

                    <div class="services_anjali16">
                        <div class="card_anjali16">
                            <div class="icon_anjali16">
                                <i class="fa-solid fa-rotate-left" style = "color : #8789ff;"></i>
                            </div>
                            <h2>Return Policy</h2>
                            <p>In case, If you are not completely satisfied with our products or services, you can return them in their original condition within 7 days for a full refund</p>
                            <a href="{{ route('redirecting_return_policy') }}" class="button_anjali16">Read More</a>
                        </div>

                        <div class="card_anjali16">
                            <div class="icon_anjali16">
                                <i class="fa-solid fa-sack-dollar" style = "color : #8789ff;"></i>
                            </div>
                            <h2>Instant Refund</h2>
                            <p>After successfully returning your order, we will verify its condition, Once the verification process is complete, your full payment will be automatically refunded</p>
                            <a href="{{ route('redirecting_refund_policy') }}" class="button_anjali16">Read More</a>
                        </div>

                        <div class="card_anjali16">
                            <div class="icon_anjali16">
                                <i class="fa-solid fa-rotate" style = "color : #8789ff;"></i>
                            </div>
                            <h2>Exchange Policy</h2>
                            <p>If you wish to exchange the product you received, you can do so within 7 days from the delivery date. Please ensure that the product is in its original condition</p>
                            <a href="{{ route('redirecting_exchange_policy') }}" class="button_anjali16">Read More</a>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>

</main>

<script src="{{ asset('js/form.js') }}"></script>

@if (Session::has('MySession'))
    <script>
        window.onload = function() {
            let redirecting_div = document.getElementById('redirecting_div');
            redirecting_div.scrollIntoView({ behavior: 'smooth' });
        };
    </script>
@else
    <script>
        window.onload = function() {
            let successScroll = document.getElementById('successScroll');
            successScroll.scrollIntoView({ behavior: 'smooth' });
        };
    </script>
@endif
