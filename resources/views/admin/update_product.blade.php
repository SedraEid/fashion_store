<!<!DOCTYPE html>
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
      @include('admin.sidebar')
      <div class="modal-body">
  <form action="{{url('/update_product_confirm',$products->id)}}" method="POST"  enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" style="color: black;background-color: white;" class="form-control" id="title" name="title" value="{{ $products->title }}" >
    </div>
    <div class="form-group">
      <label for="description">Description:</label>
      <textarea class="form-control" id="description" name="description"  style="color: black;background-color: white;" name=description rows=10 style=height: 300px;>{{ $products->description }}</textarea>
    </div>
    <div class="form-group">
      <label for="small_description">Small Description:</label>
      <textarea  style="height: 300px;color: black;background-color: white;" class="form-control" id="small_description" name="small_description" rows="3">{{ $products->small_description }}</textarea>
    </div>
    <div class="form-group">
    <label for="trending">Trending:</label>
    <select name="trending" id="trending" class="form-control">
        <option value="1" {{ $products->trending == 1 ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ $products->trending == 0 ? 'selected' : '' }}>No</option>
    </select>
</div>
    <div class="form-group">
      <label for="category">Category:</label>
      <select class="form-control" id="category" name="category">
        @foreach ($category as $cat)
          <option value="{{ $cat->id }}" {{ $products->category == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
        @endforeach
      </select>
    </div>
   <div class="form-group">
    <label for="brand_id">Brand:</label>
    <select class="form-control" id="brand_id" name="brand_id">
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}" {{ $products->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
        @endforeach
    </select>
</div>
    <div class="form-group">
      <label for="price">Price:</label>
      <input type="number" class="form-control" id="price" name="price" value="{{ $products->price }}" step="0.01">
    </div>
    <div class="form-group">
      <label for="quantity">Quantity:</label>
      <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $products->quantity }}">
    </div>
    <div class="form-group">
      <label for="discountprice">Discount Price:</label>
      <input type="number" class="form-control" id="discountprice" name="discountprice" value="{{ $products->discountprice }}" step="0.01">
    </div>
    <div class="form-group">
      <label for="image">Image:</label>
      <input type="file" name="image">
    </div>
    <div class="form-group">
      <label for="image_path[]">Files upload:</label>
      <input type="file" name="image_path[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary me-2">Update</button>
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
  </form>
</div>

              </html>
              @include('admin.script')
            </body>
              <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../assets/js/file-upload.js"></script>
    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/select2.js"></script>
    <!-- End custom js for this page -->