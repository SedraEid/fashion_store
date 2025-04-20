<!DOCTYPE html>
<html lang="en">

<style>


.grid-container {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 10px;
}

.grid-item {
  text-align: center;
}
</style>
@include('admin.css')

 
  <body>
    <div class="container-scroller">
      <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="ps-lg-1">
              <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                <a href="https://www.bootstrapdash.com/product/corona-free/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <a href="https://www.bootstrapdash.com/product/corona-free/"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="main-panel">
      <div class="container-fluid page-body-wrapper">
      <div class="col-lg-12 stretch-card">
                <div class="card">
                  <div class="card-body">
                
                    </p>
                    <div class="table-responsive">
                      <table class="table table-bordered table-contextual">
                   
  <thead>
    <tr>
     
    <th>customer Name</th>
    <th>Address</th>
    <th>Phone</th>
    <th>Product Title</th>
    <th>Price</th>
    <th>Image</th>
    <th>Status</th>
    <th>Change Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $data)
    <tr class="{{$data['class'] }}">
    
      <td>{{ $data->name }}</td>
    
     
      <td>{{ $data->rec_address }}</td>
      <td>{{ $data->phone}}</td>
      <td>{{ $data->product->title }}</td>
      <td>{{ $data->product->price}}</td>
    
      <td>
    <img src="{{ asset('product_images/' . $data->product->image) }}"  class="product-image" style="width: 50px; height: 50px;" />
</td>
<td>
    @if($data->status=='in progress')

<span style="color: red;">{{ $data->status}}</span>
@elseif($data->status=='on the way')
<span style="color: green;">{{ $data->status}}</span>
@else
<span style="color: yellow;">{{ $data->status}}</span>

    @endif


</td>

<td>{{ $data->status}}</td>
<td  class="grid-container" >
<div class="grid-item">
    <a class="btn btn-primary" href="{{url('on_the_way',$data->id)}}">ON the Way</a>
  </div>
  <div class="grid-item">
    <a class="btn btn-success" href="{{url('delivered',$data->id)}}">Delivered</a>
  </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

                      </table>
                    </div>
                  </div>
                </div>
              </div>
      </div>
      <!-- page-body-wrapper ends -->
    </div>




    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="admin/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="admin/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="admin/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="admin/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="admin/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="admin/assets/js/off-canvas.js"></script>
    <script src="admin/assets/js/hoverable-collapse.js"></script>
    <script src="admin/assets/js/misc.js"></script>
    <script src="admin/assets/js/settings.js"></script>
    <script src="admin/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="admin/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>