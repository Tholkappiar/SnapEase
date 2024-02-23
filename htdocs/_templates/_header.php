<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="assets/js/color-modes.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">

  <title>Headers · Bootstrap v5.3</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


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
            if (isset($uid)) {
              $user = new User($uid);
              $username = $user->data['username'];
            }

            // Total Followers and Following Count
            $follow = new Follow();
            ?>
            <? if(isset($username)) { ?>
            <div class="modal-body">
              <div class="mb-3">
                <span style="font-size: 16px; font-weight: bold;" class="text-muted">Welcome ,</span>
                <span style="font-size: 18px; font-weight: bold;"><?= " " . $username . " " ?>!</span>
              </div>
              <div class="d-flex justify-content-around">
                <div id="followers-main" data-bs-target="#followers-toggle" data-bs-dismiss="modal" data-bs-toggle="modal">
                  <strong class="mb-2">Followers</strong>
                  <p class="mb-2" id="followers-count"></p>
                </div>
                <div id="following-main" data-bs-target="#following-toggle" data-bs-dismiss="modal" data-bs-toggle="modal">
                  <strong class="mb-2">Following</strong>
                  <p class="mb-2" id="following-count"></p>
                </div>
              </div>
            </div>
            <? } ?>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
          </div>
        </div>
      </div>
      
      <!-- Modal for Followers List -->
      <div class="modal fade" id="followers-toggle" aria-hidden="true" aria-labelledby="followersToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="followersToggleLabel">Followers List</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul id="followers-list"></ul>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="following-toggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel2">Following List</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul id="following-list"></ul>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
  </div>
</body>

</html>