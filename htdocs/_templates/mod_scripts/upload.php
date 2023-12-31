<section class="py-5 text-center container">
	<div class="row py-lg-5">
		<form method="post" action="/" enctype="multipart/form-data" class="col-lg-6 col-md-8 mx-auto">
			<h1 class="fw-light">What are you upto?</h1>
			<p class="lead text-muted">Share a photo that talks about it.</p>
			<p>
			<div class="d-grid gap-3">
				<div class="form-floating">
					<textarea name="post_caption" class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
					<label for="floatingTextarea">Caption</label>
				</div>
				<input name="post_image" accept="image/*" class="form-control form-control-lg" id="formFileLg" type="file">
			</div>
			<button type="submit" class="btn btn-success my-2">Upload</button>
			</p>
		</form>
	</div>
</section>