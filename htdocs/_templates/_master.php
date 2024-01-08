<?php

include_once "_libs/load.php";

Sessions::load_template("_header");
Sessions::current_script();
Sessions::load_template("_footer");

?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>
<script src="/js/dialog.js"></script>
<script src="/js/app.min.js"></script>

 <!-- This the dummy division which is used to create the dialogs by clone it  -->
<div id="modalsGarbage">
    <div class="modal fade animate__animated" id="dummy-dialog-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content blur" style="box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
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
<script>

    // TODO : Remove the api and generate the normal the fingerprint.

    // Initialize the agent once at web application startup.
    // Alternatively initialize as early on the page as possible.
    var fPromise = import('https://openfpcdn.io/fingerprintjs/v3')
        .then(FingerprintJS => FingerprintJS.load())

    // Analyze the visitor when necessary.
    fPromise
        .then(fp => fp.get())
        .then(result => {
            const visitorId = result.visitorId;
            // console.log(visitorId);
            document.getElementById('fingerprint').value = visitorId;
        })

    // console.log(result.requestId, "visitor : " + result.visitorId))
</script>
