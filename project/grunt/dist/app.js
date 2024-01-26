/*Processed by Thols Labs on 26/1/2024 @ 9:17:36 https://www.github.com/tholkappiar */
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

    if ($(this).hasClass('fa-regular')) {
        $(this).removeClass('fa-regular').addClass('fa-solid').css('color', '#fe4d4d').addClass('like-animation'); // Liked
    } else {
        $(this).removeClass('fa-solid').addClass('fa-regular').css('color', '#ffffff').addClass('like-animation'); // Not liked
    }
    $.post('/api/post/like', {
        post_id: post_id
    }, function(data, textSuccess){
        if(textSuccess == "success"){
            setTimeout(function() {
                $($this).removeClass('like-animation');
            }, 1000);
            if(data.liked){
                $($this).removeClass('fa-regular').addClass('fa-solid').css('color', '#fe4d4d'); // Liked
            } else {
                $($this).removeClass('fa-solid').addClass('fa-regular').css('color', '#ffffff'); // Not liked
            }
        }
        
    });
});

$('.follow-user').on('click', function(){
    post_id = $(this).closest('.col-lg-4').attr('id').replace('post-', '');
    console.log(post_id);
    $this = $(this);

    if ($(this).hasClass('fa-user-plus')) {
        $(this).removeClass('fa-user-plus').addClass('fa-user-minus'); 
    } else {
        $(this).removeClass('fa-user-minus').addClass('fa-user-plus');
    }

    $.post('/api/post/follow', {
        post_id: post_id
    }, function(data, textSuccess){
        if(textSuccess == "success"){
            console.log("sucess da");
        }
        
    });
});
//# sourceMappingURL=app.js.map