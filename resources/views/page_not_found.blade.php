<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>SHUBHSTEP | 404 Error Page</title>
      <link rel="stylesheet" href="{{ asset('cssfiles/page_not_found.css') }}">
   </head>
   <body>
      <div id="error-page">
         <div class="content">
            <h2 class="header" data-text="404">
               404
            </h2>
            <h4 data-text="Opps! Page not found">
               Opps! Page not found
            </h4>
            <p>
               Sorry, the page you're looking for doesn't exist. If you think something is broken, report a problem.
            </p>
            <div class="btns">
               <a href="{{ route('main_initial_page') }}">return at home</a>
               <!-- <a href="/">report problem</a> -->
            </div>
         </div>
      </div>
   </body>
</html>