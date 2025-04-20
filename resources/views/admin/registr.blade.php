<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('admin1/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ url('admin1/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('admin1/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Admin</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form id="seller-register-form">
        @csrf

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Full name" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="phone" placeholder="Phone">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-phone"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="address" placeholder="Address">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="store_name" placeholder="Store Name" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-store"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="date" class="form-control" name="birthdate" placeholder="Birthdate" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="city" placeholder="City">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-city"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
            <label class="form-check-label" for="male">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>

        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>

      <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="{{ url('admin1/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ url('admin1/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('admin1/js/adminlte.min.js') }}"></script>

<!-- Custom AJAX Submit Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#seller-register-form');
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(form);

      fetch("{{ route('seller.register') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
        if (data.redirect_url) {
          window.location.href = data.redirect_url;
        } else if (data.message) {
          alert(data.message);
        } else if (data.errors) {
          let errors = Object.values(data.errors).flat().join('\n');
          alert("الأخطاء:\n" + errors);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ غير متوقع');
      });
    });
  });
</script>

</body>
</html>
