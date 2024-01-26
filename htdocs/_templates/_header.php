<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="assets/js/color-modes.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.118.2">
  <title>Headers · Bootstrap v5.3</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4">SnapEase</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/All_post.php" class="nav-link" aria-current="page"><i class="fa-solid fa-magnifying-glass"></i></a></li>
        <?
        if (Sessions::isAuthenticated()) {
        ?>
          <li class="nav-item"><a href="/?logout" class="nav-link">Logout</a></li>
          <li id="profile" class="nav-item">
            <a class="fa-regular fa-user nav-link header-profile" data-bs-toggle="modal" data-bs-target="#profileModal"></a>
          </li>
        <?
        } else {
        ?>
          <li class="nav-item"><a href="/login.php" class="nav-link">Login</a></li>
        <?
        }
        ?>
      </ul>
      <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content text-center">
            <div class="modal-header">
              <h5 class="modal-title text-center mx-auto" id="exampleModalCenterTitle"><i class="fa-regular fa-user p-0" style="color: #ffffff;"></i></h5>
            </div>
            <? 
              // Get Username for the user.
              $uid = Sessions::get('uid');
              if(isset($uid)){
                $user = new User($uid);
                $username = $user->data['username'];
              }

              // Total Followers and Following Count
              $follow = new Follow();
            ?>
            <div class="modal-body">
              <div class="mb-3">
                <span style="font-size: 16px; font-weight: bold;" class="text-muted">Welcome ,</span>
                <span style="font-size: 18px; font-weight: bold;"><?=" " . $username . " "?>!</span>
              </div>
              <div class="d-flex justify-content-around">
                <div>
                  <strong class="mb-2">Followers</strong>
                  <p class="mb-2" id="followers-count"></p>
                </div>
                <div>
                  <strong class="mb-2">Following</strong>
                  <p class="mb-2" id="following-count"></p>
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
          </div>
        </div>
      </div>
  </div>
</body>
</html>