<!doctype html>
<html lang="en">

<head>
  <script src="assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.118.2">
  <title>Headers · Bootstrap v5.3</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">




  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4">Simple header</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/All_post.php" class="nav-link active" aria-current="page"><i class="fa-solid fa-magnifying-glass"></i></a></li>
        <? 
          if(Sessions::isAuthenticated())
          {
        ?>
            <li class="nav-item"><a href="/?logout" class="nav-link">Logout</a></li>
            <li class="nav-item"><i class="fa-regular fa-user nav-link"></i></li>
        <? 
          }  else { 
            ?>
            <li class="nav-item"><a href="/login.php" class="nav-link">Login</a></li>
            <?
          }
        ?>
      </ul>
    </header>
  </div>

  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />