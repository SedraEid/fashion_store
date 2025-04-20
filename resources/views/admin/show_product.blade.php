<!DOCTYPE html>
<html lang="en">
  <head>
  <style>
    .action-buttons {
        display: flex;
        justify-content: space-around;
    }
    .action-buttons a {
        margin-right: 5px; /* Adjust the margin as needed */
    }
    .styled-table {
    width: 100%; /* تأكد من أن الجدول يأخذ العرض الكامل */
    border-collapse: collapse; /* لجعل الحدود متجاورة */
}

.styled-table td {
    word-wrap: break-word; /* يسمح بتفكيك الكلمات الطويلة */
    overflow-wrap: break-word; /* لتفكيك الكلمات الطويلة */
}
.action-buttons {
    display: flex;
    flex-direction: column; /* ترتيب العناصر عمودياً */
}

.action-buttons a {
    margin-bottom: 5px; /* إضافة مسافة بين الأزرار */
}

<style>
    .styled-table {
        width: 100%; /* جعل الجدول يأخذ عرض الصفحة بالكامل */
        border-collapse: collapse; /* دمج الحدود */
    }

    .styled-table th, .styled-table td {
        border: 1px solid #ddd; /* إضافة حدود خفيفة */
        padding: 8px; /* إضافة مسافة داخل الخلايا */
        text-align: left; /* محاذاة النص إلى اليسار */
    }

    .styled-table th {
        background-color: #f2f2f2; /* لون خلفية لرؤوس الجدول */
        color: black; /* لون النص لرؤوس الجدول */
    }

    .styled-table tr:nth-child(even) {
        background-color: #f9f9f9; /* لون خلفية للصفوف الزوجية */
    }

    .styled-table tr:hover {
        background-color: #f1f1f1; /* تأثير التمرير على الصفوف */
    }

    .action-buttons {
        display: flex;
        flex-direction: column; /* ترتيب الأزرار عمودياً */
    }

    .action-buttons a {
        margin-bottom: 5px; /* إضافة مسافة بين الأزرار */
        text-decoration: none; /* إزالة خط تحت الروابط */
        padding: 5px 10px; /* إضافة مسافة داخل الأزرار */
        color: white; /* لون النص للأزرار */
    }

    .btn-danger {
        background-color: red; /* لون خلفية زر الحذف */
    }

    .btn-success {
        background-color: green; /* لون خلفية زر التعديل */
    }
</style>


</style>

  </head>
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
                    <table class="styled-table" style="table-layout: fixed; background-color: white; color:black" >
    <thead>
        <tr>
            <th style="width: 200px;">Title</th>
            <th style="width: 300px;">Description</th> <!-- تحديد عرض ثابت هنا -->
            <th style="width: 300px;">Small Description</th>
            <th style="width: 100px;">Quantity</th>
            <th style="width: 100px;">Category</th>
            <th style="width: 100px;">Brand</th>
            <th style="width: 100px;">Price</th>
     
            <th style="width: 100px;">Trending</th>
      
            <th style="width: 100px;">Image</th>
            <th style="width: 100px;">Additional Images</th>
            <th style="width: 200px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr class="{{$product['class'] }}">
            <td>{{ $product->title }}</td>
            <td style="height: 200px; word-wrap: break-word;">{{ $product->description }}</td>
            <td>{{ $product->small_description }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->Category->category_name}}</td>
            <td>{{$product->brand->name}}</td>
            <td>{{ $product->price }}</td>
       
            <td>{{ $product->trending == 1 ? 'Trending' : 'Not Trending' }}</td>
   
            <td>
                <img src="{{ asset('product_images/' . $product->image) }}" alt="{{ $product->title}}" class="product-image" style="width: 50px; height: 50px;" />
            </td>
            <td>
                @foreach ($product->images as $image)
                <img src="{{ asset($image->image_path) }}" alt="" class="product-image" style="width: 50px; height: 50px;" />
                @endforeach
            </td>
            <td class="action-buttons">
    <a class="btn btn-danger" href="{{ url('delete_product', $product->id) }}" onclick="return confirm('Are you sure to delete this product?')">Delete</a>
    <a class="btn btn-success" href="{{ url('update_product', $product->id) }}">Edit</a>
</td>

        </tr>
        @endforeach
    </tbody>
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