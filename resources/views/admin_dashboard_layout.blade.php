<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  @yield("title")
  @yield("style")
  <link rel="stylesheet" href="assets_3_admin_dashboard/css/app.min.css">
  <link rel="stylesheet" href="assets_3_admin_dashboard/css/style.css">
  <link rel="stylesheet" href="assets_3_admin_dashboard/css/components.css">
  <link rel="stylesheet" href="assets_3_admin_dashboard/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets_3_admin_dashboard/img/favicon.png' />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- ------------------ header ------------------ -->
          @include('admin_dashboard_header')
      <!-- -->

      <!-- ------------------ sidebar ------------------ -->
          @include('admin_dashboard_sidebar')
      <!-- -->

      <!-- Main Content -->
          @yield('body')
      <!-- -->

      <!-- footer -->
          @include('admin_dashboard_footer')
      <!-- -->

    </div>
  </div>
  <script src="assets_3_admin_dashboard/js/app.min.js"></script>
  <script src="assets_3_admin_dashboard/bundles/apexcharts/apexcharts.min.js"></script>
  <script src="assets_3_admin_dashboard/js/page/index.js"></script>
  <script src="assets_3_admin_dashboard/js/scripts.js"></script>
  <script src="assets_3_admin_dashboard/js/custom.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
         $('.close-btn-anjali').click(function(){
            $('.alert').css("display", "none");
         });

         $('.close-btn-anjali2').click(function(){
            $('.alert-anjali').css("display", "none");
         });

          $("#swal-6").click(function () {
            swal({
              title: 'Are you sure?',
              text: 'Are you sure to logout from your current account !',
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            })
              .then((willDelete) => {
                if (willDelete) {
                  window.location.href = "/admin_logout";
                }
              });
          });

          $("#headerLogout").click(function () {
            swal({
              title: 'Are you sure?',
              text: 'Are you sure to logout from your current account !',
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            })
              .then((willDelete) => {
                if (willDelete) {
                  window.location.href = "/admin_logout";
                }
              });
          });

          $("#dashboard_logout").click(function () {
            swal({
              title: 'Are you sure?',
              text: 'Are you sure to logout from your current account !',
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            })
              .then((willDelete) => {
                if (willDelete) {
                  window.location.href = "/admin_logout";
                }
              });
          });

  </script>
  @yield('script')

</body>

</html>