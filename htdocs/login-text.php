<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./login.css">
</head>

<body class="col-4 d-table">
  <!-- partial:index.partial.html -->
  <div id="login-animate">
    <div id="container" class="custom-container">
      Make
      <div id="flip" class="flip-container">
        <div class="flip-text">
          <div class="work">wOrK</div>
        </div>
        <div class="flip-text">
          <div class="lifestyle">lifeStyle</div>
        </div>
        <div class="flip-text">
          <div class="everything">Everything</div>
        </div>
      </div>
      AweSoMe!
    </div>
  </div>




  <div class="card-body p-4 p-lg-5 text-black">

    <form method="post" action="login.php">

      <div class="d-flex align-items-center mb-3 pb-1">
        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
        <span class="h1 fw-bold mb-0">Logo</span>
      </div>

      <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

      <div class="mb-3">
        <label for="exampleDropdownFormEmail2" class="form-label">Email address</label>
        <input name="login-email" type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
      </div>
      <div class="mb-3">
        <label for="exampleDropdownFormPassword2" class="form-label">Password</label>
        <input name="login-password" type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
      </div>
      <input name="login-fingerprint" type="hidden" class="form-control" id="fingerprint">
      <div class="pt-1 mb-4">
        <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
      </div>

      <a class="small text-muted" href="#!">Forgot password?</a>
      <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!" style="color: #393f81;">Register here</a></p>
      <a href="#!" class="small text-muted">Terms of use.</a>
      <a href="#!" class="small text-muted">Privacy policy</a>
    </form>

  </div>

</body>

</html>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet" />