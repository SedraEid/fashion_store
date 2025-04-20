<!DOCTYPE html>
<html lang="en">
<base href="/public">
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


                    <div class="div_center">
  <h1>brans</h1>
    @if(session()->has('message'))
        <div>
            <div id="true">
                {{session()->get('message')}}
            </div>
        </div>
    @endif
    <form action="{{ url('/Addbrand') }}" method="POST">
    @csrf
    <label for="name">Brand Name:</label>
    <input type="text" name="name" id="brand_name" required>
    <button type="submit">Add</button>
    <div class="form-group">
                        <label for="category">Product Category:</label>
                        <select name="category" id="exampleSelectGender" required>
                          <option value="">Select a category</option>
                          @foreach ($category as  $category)
                        <option value="{{$category->id}} ">{{$category->category_name}}  </option>
                        @endforeach
                        </select>
                      </div>
</form>
                    <div class="table-responsive">
                      <table class="table table-bordered table-contextual">
                   
  <thead>
    <tr>
     
    <th>brand  Name</th>
    <th>Action</th>
    </tr>
  </thead>
  <tbody>
            @foreach ($brands as $brands)
                <tr>
                <td>{{ $brands->name }}</td>
               
                    <td>
                        <a class="btn btn-danger" href="{{url('deletebrand', $brands->id)}}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>

</div>
     
     </div>
     </div>
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