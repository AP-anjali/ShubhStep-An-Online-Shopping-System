@extends('customer_dashboard_layout')

@section('title')
<title>Completed Orders</title>
@endsection

@section('style')
<style>
    .gfg {
        border-collapse:separate;
        border-spacing:0 15px;
    }

    #Completed_Record{
        font-weight : 700 !important;
        color : #454545 !important;
    }

    .star-rating .hehe {
        font-size: 1.3rem;
        color: #FFBD13;
        font-weight : 600;
    }

    .form-control.star-rating {
        font-size: 1rem;
        padding: 5px;
    }
</style>
@endsection

@section('body')
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-6" style = "margin : auto ; margin-top : 1rem;">
            <form method = "post" action = "{{ route('storing_feedback') }}">
                @csrf
                <div class="card">
                <div class="card-header">
                    <h4>Order Feedback</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                      <label>Product Name</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $FeedbackOrderData->product->product_name }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Product Title</label>
                      <input style = "font-weight : 700;" type="text" class="form-control" value = "{{ $FeedbackOrderData->product->product_title }}" readonly>
                    </div>

                    <div class="form-group">
                      <label><i class="fa-solid fa-star"></i> Star Rating</label>
                      <select class="form-control star-rating" name="star_rating" required>
                          <option value = "" style = "text-align : center;" selected disabled>-- &nbsp; Select Star Rating &nbsp; --</option>
                          <option value="1" class = "hehe">&#9733;</option>
                          <option value="2" class = "hehe">&#9733;&#9733;</option>
                          <option value="3" class = "hehe">&#9733;&#9733;&#9733;</option>
                          <option value="4" class = "hehe">&#9733;&#9733;&#9733;&#9733;</option>
                          <option value="5" class = "hehe">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label>Feedback Text</label>
                      <textarea class="form-control" name = "feedback_text" required></textarea>
                    </div>

                    <input type="hidden" name="order_id" value = "{{ $FeedbackOrderData->id }}">
                    <input type="hidden" name="customer_id" value = "{{ $FeedbackCustomer->id }}">
                    
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

@section('script')
  <script>
    let orders = document.getElementById("orders");
    orders.classList.add("active");
  </script>
@endsection
