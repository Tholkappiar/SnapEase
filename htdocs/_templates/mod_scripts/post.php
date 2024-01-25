<div class="album py-5">
  <div class="container">

    <div class="row" data-masonry='{"percentPosition": true }'>
      <?php
      $posts = Post::getAllPost();

      use Carbon\Carbon;

      foreach ($posts as $post) {
        $p = new Post($post['id']);
        $user = new User($post['uid']);
        $uploaded_time = Carbon::parse($p->getUploadedTime());
        $uploaded_time_str = $uploaded_time->diffForHumans();


        $userid = $user->id;
        $postid = $post['id'];
        $id = md5($userid . $postid);
        $like = new like();
        $like_cond = $like->liker($id);
        // print("this is like : " . $like);

      ?>
        <div class="col-lg-4 mb-4" id="post-<?= $post['id'] ?>">
          <div class="card">
            <img class="bd-placeholder-img card-img-top" src="<?= $p->getImageUri() ?>">
            <div class="card-body">
             <!-- $p->getPostText() -->
              <p class="card-text"><?=$p->getPostText()?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group" data-id="<?= $post['id'] ?>">
                  <?
                  if ($like_cond == Sessions::get('uid')) {
                  ?>
                    <button type="button" class="btn btn-sm btn-primary btn-like">Liked</button>
                  <?php
                  } else {
                  ?>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-like">Like</button>
                  <?php
                  }
                  ?>
                  <button type="button" class="btn btn-sm btn-outline-success">Share</button>
                  <?
                  if (Sessions::isOwner($p->getUid())) {
                  ?>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                  <?
                  }
                  ?>
                </div>
                <small class="text-muted"><?= $uploaded_time_str . " by " . $user->data['username'] ?></small>
              </div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>