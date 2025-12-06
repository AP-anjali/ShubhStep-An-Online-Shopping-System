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
                    <h1>Frequently Asked Questions</h1>
                </div>

                <ul id = "accordion_anjali">

                    <div style = "font-size : 1.2rem; color : #8789ff; margin-bottom : 1rem;">
                        <i class="fa-solid fa-right-long"></i> &nbsp; <b>General Questions</b>
                    </div>

                    <li>
                        <label for="first">Who can use this website?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="first" checked>
                        <div class="content_anjali20">
                            <p>
                                Our website is designed exclusively for customers who wish to purchase our wide range of decorative products. Whether you're shopping for yourself or looking for the perfect gift, our user-friendly platform makes it easy to browse, select, and buy the products you love. You need to create an account to enjoy a personalized shopping experience, track orders, and manage returns or exchanges seamlessly.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="second">How can I create an account?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="second">
                        <div class="content_anjali20">
                            <p>
                                To access certain features of the website, such as adding products to the cart or wishlist, and purchasing products, you are required to create an account. You must provide accurate and complete information during the registration process. You are responsible for maintaining the confidentiality of your account and orders.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; You can register manually by providing the following details :
                                <br>
                                1] Your Full Name
                                <br>
                                2] Your Phone Number (for communication purposes)
                                <br>
                                3] Your Email Address (for notification purposes)
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; Alternatively, you can log in directly using your existing Google account. In this method, your name and email address will be saved initially, and you will need to manually add your phone number for communication purposes.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; In both methods, you must provide your proper address for delivery purposes. You can access your address status, and can add or change your address details in your account page, in address section.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; To order any product from SHUBHSTEP, you must provide all the details mentioned above to ensure the proper communication, notification, and delivery processes.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="xyz">Can I change my account details?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="xyz">
                        <div class="content_anjali20">
                            <p>
                                You can easily update your account details, including your name, phone number, email address, and delivery address. Simply visit your profile page to make the changes.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; Please note that, after changing your email address or phone number, you will need to log in again. This is to ensure data security and user authentication. Behind this, our aim is to eliminate fake orders, and other type of offences.
                            </p>
                        </div>
                    </li>

                    <div style = "font-size : 1.2rem; color : #8789ff; margin-bottom : 1rem; margin-top : 1.8rem;">
                        <i class="fa-solid fa-right-long"></i> &nbsp; <b>Payments Questions</b>
                    </div>

                    <li>
                        <label for="third">What payment methods do you accept?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="third">
                        <div class="content_anjali20">
                            <p>
                                We accept online payments via major credit cards, debit cards, and digital wallets. We also offer a Cash on Delivery (COD) option for your convenience. Please review the Payment Methods section of  <a style = "display : inline-block; color : white;" href = "{{route('terms_and_conditions')}}">' terms and condition '</a> page for more details.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="forth">Is it safe to use my credit/debit card on your website?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="forth">
                        <div class="content_anjali20">
                            <p>
                                Yes, we use industry-standard encryption to protect your personal and financial information. Your transactions are secure with us. Please review the  <a style = "display : inline-block; color : white;" href = "{{route('privacy_policy')}}">' privacy policy '</a> page for more details, which you can find in the footer section, governing the use of your personal data on our website.
                            </p>
                        </div>
                    </li>

                    <div style = "font-size : 1.2rem; color : #8789ff; margin-bottom : 1rem; margin-top : 1.8rem;">
                        <i class="fa-solid fa-right-long"></i> &nbsp; <b>Orders Questions</b>
                    </div>

                    <li>
                        <label for="fifth">How can I track my order?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="fifth">
                        <div class="content_anjali20">
                            <p>
                                After placing an order, you can track its progress by regularly checking for updates on your order status.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="khaso">Can I cancel my order?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="khaso">
                        <div class="content_anjali20">
                            <p>
                                Yes, After ordering any product from SHUBHSTEP, you can cancel your order until our team accepts your order request. Please note that after acceptance of your order by our team, you cannot cancel your order!, Please review the Order Cancellation section of <a style = "display : inline-block; color : white;" href = "{{route('terms_and_conditions')}}">' terms and condition '</a> page for more details.
                            </p>
                        </div>
                    </li>

                    <div style = "font-size : 1.2rem; color : #8789ff; margin-bottom : 1rem; margin-top : 1.8rem;">
                        <i class="fa-solid fa-right-long"></i> &nbsp; <b>Returns and Exchanges Questions</b>
                    </div>

                    <li>
                        <label for="vacchee1">How do I return or exchange an item?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="vacchee1">
                        <div class="content_anjali20">
                            <p>
                                To return or exchnage the product you received, you have to fill out the return/exchange application form, which you can found in your ' completed orders ' section. Please review the Return Policy and Exchange Policy section of <a style = "display : inline-block; color : white;" href = "{{route('terms_and_conditions')}}">' terms and condition '</a> page for more details.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="vacchee">What is your return and exchange policy?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="vacchee">
                        <div class="content_anjali20">
                            <p>
                                We offer a 7-day return and exchnage policy. You can return or exchange a product within 7 days of receiving it. Please note that each return or exchange can be done just once. Please review the Return Policy and Exchange Policy section of <a style = "display : inline-block; color : white;" href = "{{route('terms_and_conditions')}}">' terms and condition '</a> page for more details.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="sixth">When will I receive my refund?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="sixth">
                        <div class="content_anjali20">
                            <p>
                                In case of order returns, refunds are processed within 7-10 business days after we receive the returned item. Please review the 'Refund Guarantee Policy' section of <a style = "display : inline-block; color : white;" href = "{{route('terms_and_conditions')}}">' terms and condition '</a> page for more details.
                            </p>
                        </div>
                    </li>

                    <div style = "font-size : 1.2rem; color : #8789ff; margin-bottom : 1rem; margin-top : 1.8rem;">
                        <i class="fa-solid fa-right-long"></i> &nbsp; <b>Customer Support Questions</b>
                    </div>

                    <li>
                        <label for="new1">How do I contact to customer support?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="new1">
                        <div class="content_anjali20">
                            <p>
                                For any questions, queries, or problems, you can notify us by filling out the <a style = "display : inline-block; color : white;" href = "{{route('customer_support')}}">' customer support '</a> form available in the footer section.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="new2">What should I do if I encounter technical or any issues on the website?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="new2">
                        <div class="content_anjali20">
                            <p>
                            For technical support or any other type of issues, you can contact with us by filling out the <a style = "display : inline-block; color : white;" href = "{{route('contact_us')}}">' contact us '</a> form which you can found in footer section.
                            </p>
                        </div>
                    </li>

                    <div style = "font-size : 1.2rem; color : #8789ff; margin-bottom : 1rem; margin-top : 1.8rem;">
                        <i class="fa-solid fa-right-long"></i> &nbsp; <b>Feedback Questions</b>
                    </div>

                    <li>
                        <label for="new3">How can I provide feedback or suggestions?<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="new3">
                        <div class="content_anjali20">
                            <p>
                            We value your feedback and suggestions. to provide feedback or suggestions, you can fill out the <a style = "display : inline-block; color : white;" href = "{{route('feedback_form')}}">' feedback '</a> form which is located in footer section.
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