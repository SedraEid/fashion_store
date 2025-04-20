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
  <h1>Category</h1>
  @if(session()->has('message'))
    <div>
      <div id="true">
        {{ session()->get('message') }}
      </div>
    </div>
  @endif
  <form action="{{ url('/Addcatagory') }}" method="POST">
    @csrf
    <label for="category_name">Category name</label>
    <input type="text" name="category_name" id="category_name" placeholder="ادخل القسم"  required>

    <label for="brands">Brands</label>
    <div id="brands-container">
      <input type="text" name="brands[]" placeholder="ادخل الماركة" required>
    </div>
    <button type="button" onclick="addBrand()">Add Another Brand</button>

    <button type="submit">Add</button>
  </form>

  <script>
    function addBrand() {
      const container = document.getElementById('brands-container');
      const input = document.createElement('input');
      input.type = 'text';
      input.name = 'brands[]';
      input.placeholder = 'Enter brand name';
      input.required = true;
      container.appendChild(input);
    }
  </script>

  <div class="table-responsive">
    <table class="table table-bordered table-contextual">
      <thead>
        <tr>
          <th>Category Name</th>
          <th>Brands</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($category as $category)
          <tr>
            <td>{{ $category->category_name }}</td>
            <td>
              @foreach ($category->brands as $brand)
                {{ $brand->name }}@if (!$loop->last), @endif
              @endforeach
            </td>
            <td>
              <a class="btn btn-danger" href="{{ url('deleteCategory', $category->id) }}">Delete</a>
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