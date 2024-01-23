//  // TODO : Remove the api and generate the normal the fingerprint.

//     // Initialize the agent once at web application startup.
//     // Alternatively initialize as early on the page as possible.
//     const fpPromise = import('https://openfpcdn.io/fingerprintjs/v3')
//         .then(FingerprintJS => FingerprintJS.load())

//     // Analyze the visitor when necessary.
//     fpPromise
//         .then(fp => fp.get())
//         .then(result => {
//             const visitorId = result.visitorId;
//             // console.log(visitorId);
//             document.getElementById('fingerprint').value = visitorId;
//         })

    // console.log(result.requestId, "visitor : " + result.visitorId))

    $(document).on('click', '.btn-delete', function(){
        post_id = $(this).parent().attr('data-id');
        d = new Dialog("Delete Post", "Are you sure want to remove this post");
        d.setButtons([
            {
                'name': "Delete",
                "class": "btn-danger",
                "onClick": function(event){
                    console.log(`Assume this post ${post_id} is deleted`);
                    // $(`#post-${post_id}`).remove();
                    
                    $.post('/api/post/delete', {
                        id: post_id
                    }, function (data, textStatus) {
                        console.log("textStatus : " + textStatus);
                        console.log("data: " + data);
                    
                        if (textStatus === "success") {
                            var el = $(`#post-${post_id}`)[0];
                            console.log('post : ' + el);
                            $grid.masonry('remove', el).masonry('layout');
                        }
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        console.log("AJAX request failed: " + textStatus, errorThrown);
                    });
    
                    $(event.data.modal).modal('hide')
                }
            },
            {
                'name': "Cancel",
                "class": "btn-secondary",
                "onClick": function(event){
                    $(event.data.modal).modal('hide');
                }
            }
        ]);
        d.show();
    });
    
    

$('.btn-like').on('click', function(){
    post_id = $(this).parent().attr('data-id');
    $this = $(this);
    $(this).html() == "Like" ? $(this).html("Liked") : $(this).html("Like");
    $(this).hasClass('btn-outline-primary') ? $(this).removeClass('btn-outline-primary').addClass('btn-primary') : $(this).removeClass('btn-primary').addClass('btn-outline-primary');
    $.post('/api/post/like', {
        id: post_id
    }, function(data, textSuccess, xhr){
        if(textSuccess == "success"){
            if(data.liked){
                $($this).html("Liked");
                $($this).removeClass('btn-outline-primary').addClass('btn-primary');
            } else {
                $($this).html("Like");
                $($this).removeClass('btn-primary').addClass('btn-outline-primary');
            }
        }
    });
    // console.log('hi')
});