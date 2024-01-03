<?php

include_once "_libs/load.php";

Sessions::load_template("_header");
Sessions::current_script();
Sessions::load_template("_footer");

?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>

<script>
    // init Masonry
    var $grid = $('.row').masonry({
        // itemSelector: '.col',
        // columnWidth: '.col',
        percentPosition: true
    });
    // layout Masonry after each image loads
    $grid.imagesLoaded().progress(function() {
        $grid.masonry('layout');
    });
</script>