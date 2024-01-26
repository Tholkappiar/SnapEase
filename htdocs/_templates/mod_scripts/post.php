<div class="album py-5">
  <div class="container">

    <div class="row" data-masonry='{"percentPosition": true }'>
      <?php
      $posts = Post::getAllPost();
      $is_authenticated = Sessions::isAuthenticated(); // Check if the user is authenticated
      $user_id = $is_authenticated ? Sessions::get('uid') : null;
      
      // print("auth : " . $is_authenticated);

      use Carbon\Carbon;

      foreach ($posts as $post) {
        $p = new Post($post['id']);
        $user = new User($post['uid']);
        $uploaded_time = Carbon::parse($p->getUploadedTime());
        $uploaded_time_str = $uploaded_time->diffForHumans();


        $userid = Sessions::get('uid');
        $post_id = $post['id'];
        $id = md5($userid . $post_id);      
        $like = new like();
        $like_cond = $is_authenticated ? $like->isLiked($user_id, $post_id) : false;
        // print("this is like : " . $like_cond);

      ?>
        <div class="col-lg-4 mb-4" id="post-<?= $post['id'] ?>">
        <div class="card">
        <div class="d-flex justify-content-between post-header">
            <div>
                <i class="fa-regular fa-user p-3" style="color: #ffffff;"></i>
                <small class="h6 p-3 pb-0 ps-0"><?= $user->data['username'] ?></small>
            </div>
            <i class="fa-solid fa-user-plus p-3 follow-user" style="color: #ffffff;"></i>
        </div>
            <img class="bd-placeholder-img card-img-top p-3" src="<?= $p->getImageUri() ?>">
            <div class="card-body pt-0">
                <p class="card-text"><?= $p->getPostText() ?></p>
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Like button -->
                    <div class="btn-group" data-id="<?= $post['id'] ?>">
                        <?php if($like_cond) { ?>
                            <i class="fa-solid fa-heart btn-like me-3 fa-lg" style="color: #fe4d4d;"></i>
                        <?php } else { ?>
                            <i class="fa-regular fa-heart btn-like me-3 fa-lg" style="color: #ffffff;"></i>
                        <?php } ?>
                        <!-- Other buttons -->
                        <i class="fa-solid fa-share me-3 fa-lg" style="color: #ffffff;"></i>
                        <?php if (Sessions::isOwner($p->getUid())) { ?>
                            <i class="fa-solid fa-trash btn-delete me-3 fa-lg" style="color: #ffffff;"></i>
                        <?php } ?>
                    </div>
                    <!-- Uploaded time -->
                    <small class="text-muted"><?= $uploaded_time_str ?></small>
                </div>
            </div>
        </div>
    </div>
      <?php
      }
      ?>