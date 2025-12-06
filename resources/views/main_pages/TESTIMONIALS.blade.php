<div>

      <div class="container">

        <div class="testimonials-box">

          <!--
            - TESTIMONIALS
          -->

          <div class="testimonial">

            <h2 class="title">Main Objective</h2>

            <div class="testimonial-card">

              <img src="./assets/images/1.png" alt="Anjali Patel" class="testimonial-banner" width="70" height="70">

              <p class="testimonial-name" style = "color : #555;">SHUBHSTEP</p>

              <p class="testimonial-title" style = "text-align : justify;">At our core, we aim to provide the high-quality decorative products that honor tradition and history. Our collection is thoughtfully curated to bring you the finest handcrafted items, blending the cultural significance with aesthetic beauty, to enhance every corner of your home</p>

            </div>

          </div>



          <!--
            - CTA
          -->

          <div class="cta-container">

            <img src="./assets/images/cta-banner.jpg" alt="summer collection" class="cta-banner">

            <a class="cta-content">


              <h2 class="cta-title">Inspired by Tradition</h2>

              <p class="cta-text">Designed For You</p>

              <p class="discount" onclick = "let successScroll = document.getElementById('successScroll');
                    successScroll.scrollIntoView({ behavior: 'smooth' });" style = "cursor : pointer;">Shop now</p>

            </a>

          </div>



          <!--
            - SERVICE
          -->

          <div class="service">

            <h2 class="title">Our Services</h2>

            <div class="service-container">

              <a href="{{ route('redirecting_payment_methods') }}" class="service-item">
              
                <div class="service-icon">
                  <i class="fa-solid fa-hand-holding-dollar" style = "font-size : 1.7rem;"></i>
                </div>
              
                <div class="service-content">
              
                  <h3 class="service-title">COD Payments</h3>
                  <p class="service-desc">Cash On Delivery</p>
              
                </div>
              
              </a>

              <a href="{{ route('redirecting_payment_methods') }}" class="service-item">

                <div class="service-icon">
                  <i class="fa-regular fa-credit-card" style = "font-size : 1.7rem;"></i>
                </div>

                <div class="service-content">

                  <h3 class="service-title">Secured Online Payments</h3>
                  <p class="service-desc">By RAZORPAY Gateway</p>

                </div>

              </a>

              <a href="{{ route('redirecting_short_service') }}" class="service-item">
              
                <div class="service-icon">
                  <ion-icon name="arrow-undo" style = "font-size : 1.7rem;"></ion-icon>
                </div>
              
                <div class="service-content">
              
                  <h3 class="service-title">Return Policy</h3>
                  <p class="service-desc">Within 7 days of delivery</p>
              
                </div>
              
              </a>

              <a href="{{ route('redirecting_short_service') }}" class="service-item">
              
                <div class="service-icon">
                  <i class="fa-solid fa-sack-dollar" style = "font-size : 1.7rem;"></i>
                </div>
              
                <div class="service-content">
              
                  <h3 class="service-title">Instant Refund</h3>
                  <p class="service-desc">will be initiated within 7 days</p>
              
                </div>
              
              </a>

              <a href="{{ route('redirecting_short_service') }}" class="service-item">
              
                <div class="service-icon">
                  <i class="fa-solid fa-rotate" style = "font-size : 1.7rem;"></i>
                </div>
              
                <div class="service-content">
              
                  <h3 class="service-title">Exchange Policy</h3>
                  <p class="service-desc">Easy & Free Exchange</p>
              
                </div>
              
              </a>

            </div>

          </div>

        </div>

      </div>

    </div>