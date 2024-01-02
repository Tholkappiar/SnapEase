<div class="album py-5 bg-body-tertiary">
  <div class="container">

    <div class="row" data-masonry='{"percentPosition": true }'>
      <?php
      $posts = Post::getAllPost();

      use Carbon\Carbon;

      foreach ($posts as $post) {
        $p = new Post($post['id']);
        $uploaded_time = Carbon::parse($p->getUploadedTime());
        $uploaded_time_str = $uploaded_time->diffForHumans();
      ?>
        <div class="col-lg-4 mb-4">
          <div class="card">
            <img class="bd-placeholder-img card-img-top" src="<?= $p->getImageUri() ?>">
            <div class="card-body">
              <p class="card-text"><?= $p->getPostText() ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-primary">Like</button>
                  <button type="button" class="btn btn-sm btn-outline-success">Share</button>
                  <?
                  if (Sessions::isOwner($p->getUid())) {
                  ?>
                    <button type="button" class="btn btn-sm btn-outline-danger">Delete</button>
                  <?
                  }
                  ?>
                </div>
                <small class="text-muted"><?= $uploaded_time_str ?></small>
              </div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>