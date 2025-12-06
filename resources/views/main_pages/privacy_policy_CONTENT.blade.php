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

            <div class="product-box" style = "width : 100%; border-radius : 10px; background-color: whitesmoke; overflow: hidden; box-shadow: 0 0 10px hsla(0, 0%, 0%, 0.25); margin-top: 2rem; margin-bottom : 3rem;">
            
                <div class="heading_anjali2">
                    <h1>Privacy Policy</h1>
                </div>

                <ul id = "accordion_anjali">

                    <li>
                        <label for="first">Introduction<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="first" checked>
                        <div class="content_anjali20">
                            <p>
                                Welcome to SHUBHSTEP ! We value your privacy and are committed to protecting your personal data. This Privacy Policy outlines how we collect, use, disclose, and safeguard your information when you visit our website and make purchases.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="second">Information We Collect<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="second">
                        <div class="content_anjali20">
                            <p>
                                <i class="fa-solid fa-right-long"></i> &nbsp; We may collect and process the following data about you :
                                <br><br>
                                &nbsp; &nbsp; &bull; <b>Personal Information :</b> Name, email address, phone number, and postal address, for Authentication purpose<br><br>

                                &nbsp; &nbsp; &bull; <b>Financial Information :</b> Bank account details will only be required in case of a refund for an order that was paid using the Cash on Delivery (COD) method. Here, Your banking details are encrypted, ensuring that your data is highly secure.

                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="third">How We Use Your Information<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="third">
                        <div class="content_anjali20">
                            <p>
                                <i class="fa-solid fa-right-long"></i> &nbsp; We use the information we collect in the following ways :
                                <br><br>
                                &bull; &nbsp; To authenticate you as a customer<br>
                                &bull; &nbsp; To process your orders and manage your account<br>
                                &bull; &nbsp; To comply with legal obligations and prevent fraud<br>
                                &bull; &nbsp; To provide customer support and respond to your inquiries<br>
                                &bull; &nbsp; To provide refund, in cases of order cancellation, rejection, or return<br>
                                &bull; &nbsp; To provide access to special features available exclusively to customers<br>
                                &bull; &nbsp; To personalize your shopping experience and present products tailored to you<br>
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="forth">How We Share Your Information<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="forth">
                        <div class="content_anjali20">
                            <p>
                                We do not sell, trade, or otherwise transfer your personal data to outside parties except in the following circumstances :
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; With service providers who assist in our business operations [e.g., to payment gateways for payment processing]
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="fifth">Data Security<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="fifth">
                        <div class="content_anjali20">
                            <p>
                                We implement a variety of security measures to maintain the safety of your personal data. All payment transactions are processed through a secure gateway provider and are not stored or processed on our servers. We use encryption methods to protect your data during transmission.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="vacchee">Sessions<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="vacchee">
                        <div class="content_anjali20">
                            <p>

                                Our website uses session management to enhance your browsing experience. Sessions allow us to store your preferences and manage your login state securely. Sessions are temporary and are deleted once you close your browser or log out.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="sixth">Changes to This Privacy Policy<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="sixth">
                        <div class="content_anjali20">
                            <p>
                                We may update this Privacy Policy from time to time to reflect changes in our practices or for other operational, legal, or regulatory reasons. We will notify you of any significant changes by posting the new Privacy Policy on our website.
                            </p>
                        </div>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</main>

<script src="{{ asset('js/form.js') }}"></script>

<script>
    window.onload = function() {
        let successScroll = document.getElementById('successScroll');
        successScroll.scrollIntoView({ behavior: 'smooth' });
    };
</script>