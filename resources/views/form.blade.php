<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <link rel="stylesheet" href="{{ asset('cssfiles/form.css') }}" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="container_anjali">
      
      <div class="form_anjali">
        <div class="contact-info_anjali">
          <h3 class="title_anjali">Let's get in touch</h3>

          <p class="text_anjali" style="margin-top: 1.5rem; text-align: center;">
            Hello, dear customer !
          </p>

          <p class="text_anjali" style="text-align: justify;">
            Whether you have a question about your order, our products, or anything else, our team is ready to answer all your questions. 
          </p>

          <p class="text_anjali" style="text-align: justify;">
            Our team is dedicated to providing you with the best service possible. Reach out to us through this contact form. 
          </p>

          <div style="text-align: center; margin-top: 3rem;">
            <img src="{{ asset('img/logo.png') }}" width="300" alt="logo">
          </div>
        </div>

        <div class="contact-form_anjali">
          <span class="circle one"></span>
          <span class="circle two"></span>

          <form action="index.html" autocomplete="off">
            <h3 class="title_anjali">Contact us</h3>
            <div class="input-container_anjali">
              <input type="text" name="name" class="input" required />
              <label for="">Name</label>
              <span>Name</span>
            </div>
            <div class="input-container_anjali">
              <input type="email" name="email" class="input" required />
              <label for="">Email</label>
              <span>Email</span>
            </div>
            <div class="input-container_anjali">
              <input type="tel" maxlength="10" name="phone" class="input" required />
              <label for="">Phone</label>
              <span>Phone</span>
            </div>
            <div class="input-container_anjali textarea">
              <textarea name="message" class="input" required></textarea>
              <label for="">Message</label>
              <span>Message</span>
            </div>
            <input type="submit" value="Send" class="btn_anjali" />
          </form>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/form.js') }}"></script>
  </body>
</html>