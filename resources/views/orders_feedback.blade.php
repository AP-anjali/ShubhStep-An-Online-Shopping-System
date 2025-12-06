@extends('admin_dashboard_layout')

@section('title')
<title>Orders Feedbacks</title>
@endsection

@section('style')
<style>
   .gfg {
            border-collapse:separate;
            border-spacing:0 15px;
        }
</style>
@endsection

@section('body')
    <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                            
                <div class="card">
                  <div class="card-header">
                    <h4>Orders Feedbacks</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(isset($OrderFeedback))
                        @if(count($OrderFeedback) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                    <thead>
                                    <tr>

                                        <th class="text-center">No.</th>
                                        <th style="vertical-align: middle;">Order ID</th>
                                        <th style="vertical-align: middle;">Product ID</th>
                                        <th style="vertical-align: middle;">Thumbnail</th>
                                        <th style="vertical-align: middle;">Name</th>
                                        <th style="vertical-align: middle;">Feedback Text</th>
                                        <th style="vertical-align: middle;">Star Rating</th>
                                        <th style="vertical-align: middle;">Feedback Date</th>
                                        <th style="vertical-align: middle;">Customer Details</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $srNo = 1; 
                                    @endphp

                                    @foreach($OrderFeedback as $eachOrder)

                                        <tr>
                                            <td style = "text-align : center;">{{ $srNo++ }}</td>
                                            <td style = "text-align : center;">{{ $eachOrder->id }}</td>
                                            <td style = "text-align : center;">{{ $eachOrder->product->id }}</td>
                                            
                                            <td>
                                                <img style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachOrder->product->id}}'" alt="image" src="{{ asset('storage/' . $eachOrder->product->thumbnail_image ) }}" width="100">
                                            </td>

                                            <td style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachOrder->product->id}}'">{{ $eachOrder->product->product_name }}</td>

                                            <td>{{ $eachOrder->feedback_text }}</td>                                    
                                            <td style = "white-space: nowrap;">
                                                @for ($i = 0; $i < $eachOrder->star_rating; $i++)
                                                    <i class="fas fa-star" style="font-size: 0.8rem; color: #FFBD13;"></i>
                                                @endfor
                                            </td>                                    
                                            <td>{{ $eachOrder->feedback_date }}</td>                                    

                                            <td>

                                                <form action="{{ route('customer_details_for_order') }}" method = "post" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="customer_id" value = "{{ $eachOrder->customer_id }}">
                                                    <button type="submit" class="btn btn-primary">Check</button>
                                                </form>

                                            </td>

                                        </tr>
                                        
                                    @endforeach
                                
                                    </tbody>
                                </table>

                            </div>

                        @else
                            <div style = "text-align : center;">
                                <img src="{{ asset('img/images/no_data.jpg') }}" id = "nothing">
                            </div>
                        @endif
                    @endif
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
    let Orders_Feedbacks = document.getElementById("Orders_Feedbacks");
    Orders_Feedbacks.classList.add("active");
  </script>
@endsection