@extends('admin_dashboard_layout')

@section('title')
<title>Admin Dashboard</title>
@endsection

@section('body')
  <div class="main-content">
        <section class="section">
          <div class="row ">
            
            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-dashboard'">
                <div class="card-statistic-4" >
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Dashboard</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Home Page</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/events'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Events</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/sub-events'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Sub-events</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/products'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Add New Product</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/all-products'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Uploaded Products</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-new-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">New Orders</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-cancelled-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Cancelled Orders</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-rejected-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Rejected Orders</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-accepted-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Accepted Orders</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-ready-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Ready Orders</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-completed-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Completed Orders</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-exchange-request'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">New Exchange Request</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-accepted-exchange-request'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Accepted Exchange Request</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-exchanged-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Exchnaged Orders</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-return-request'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">New Return Request</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-accepted-return-request'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Accepted Return Request</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-returned-orders'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Returned Orders</h5>
                  </div>
                </div>
              </div>
            </div>


            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/orders-feedback'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Orders Feedbacks</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/contact-mails'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Contact Mails</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/platform-feedback'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Platform Feedbacks</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/customer-support-mails'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Customer Support Mails</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" onclick = "window.location.href = '/admin-account'">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Profile</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class = "col-md-3">
              <div class="card" style = "cursor : pointer;" id = "dashboard_logout">
                <div class="card-statistic-4">
                  <div class="card-content" style = "text-align : center;">
                    <h5 class="font-15" style = "color : #454545;">Logout</h5>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
        </section>
      </div>
@endsection

@section('script')
  <script>
    let dashboard = document.getElementById("dashboard");
    dashboard.classList.add("active");
  </script>
@endsection