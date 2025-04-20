<!<!DOCTYPE html>
<html lang="en">
  <head>
 
 
   




  </head>
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

     <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <p class="card-description">add products: </p>
                
                    <form class="forms-sample" action="{{url('/add_product')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">product title</label>
                        <input type="text" class="form-control" style="color: black;background-color: white;"  id="exampleInputName1"  name="title" placeholder="Write a title" required>
                      </div>
                      <div class=form-group>
    <label for=exampleInputName1>Product Description:</label>
    <textarea class=form-control id=exampleInputName1 style="color: black;background-color: white;" name=description rows=10 style=height: 300px; placeholder=Write a description required></textarea>
</div>

                      <div class="form-group">
  <label for="smallDescription">Small Description:</label>
  <textarea style="height: 300px;color: black;background-color: white;"  class="form-control"  id="smallDescription" name="small_description" rows="20" placeholder="Write a small description" required></textarea>
</div>
<div class="form-group">
                        <label for="exampleInputName1">Product Quantity:</label>
                        <input type="number" class="form-control" id="exampleInputName1" name="quantity"  min="0" placeholder="Write a quantity" required>
                      </div>
                      <div class="form-group">
                        <label for="category">Product Category:</label>
                        <select name="category" id="exampleSelectGender" required>
                          <option value="">Select a category</option>
                          @foreach ($category as  $category)
                        <option value="{{$category->id}} ">{{$category->category_name}}  </option>
                        @endforeach
                        </select>
                      </div>
                      <div class="form-group">
    <label for="brand_id">Product brand:</label>
    <select name="brand_id" id="exampleSelectGender" required>
        <option value="">Select a brand</option>
        @foreach ($brand as $brand)
        <option value="{{ $brand->id }}">{{ $brand->name }}</option> // قم بتغيير هذا السطر
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="productPrice">Product Price:</label>
    <input type="text" class="form-control" id="productPrice" name="price" placeholder="Write a price" required>
</div>
<div class="form-group">
    <label for="trending">Trending:</label>
    <select name="trending" id="exampleSelectGender">
        <option value="1">Trending</option>
        <option value="0">Not Trending</option>
    </select>
</div>
                   
                 




                   
                      <div class="form-group">
                        <label for="exampleInputName1">Discount Price:</label>
                        <input type="text" class="form-control" id="exampleInputName1" name="discountprice" placeholder="Write a discount price">
                      </div>
                      <div class="form-group">
                        <label>File upload:</label>
                        <input type="file" name="image" required="">
                        <div class="input-group col-xs-12">
                      
                      </div>
                      <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="exampleSelectGender">
                          <option value="0">Visible</option>
                          <option value="1">Hidden</option>
                        </select>
                      </div>
            
                      <div class="form-group" style="margin-top: 20px;">
                      <label for=image_path[]>Files upload:</label>
  <input type="file" name="image_path[]" multiple>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary me-2" value="Add Product">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
                  </div>
                </div>
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
    <script>
  document.getElementById('productPrice').addEventListener('input', function() {
    const inputValue = this.value;
    const formattedValue = inputValue.replace(/[^\d,]/g, '').replace(/(\d+),(\d\d)$/, '$1.$2');
    this.value = formattedValue;
  });
</script>


   

    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/select2.js"></script>
    <!-- End custom js for this page -->