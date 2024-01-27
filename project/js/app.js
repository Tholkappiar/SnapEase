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

$(document).on('click', '.btn-delete', function () {
    post_id = $(this).parent().attr('data-id');
    d = new Dialog("Delete Post", "Are you sure want to remove this post");
    d.setButtons([
        {
            'name': "Delete",
            "class": "btn-danger",
            "onClick": function (event) {
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
            "onClick": function (event) {
                $(event.data.modal).modal('hide');
            }
        }
    ]);
    d.show();
});



$('.btn-like').on('click', function () {
    post_id = $(this).parent().attr('data-id');
    $this = $(this);

    if ($(this).hasClass('fa-regular')) {
        $(this).removeClass('fa-regular').addClass('fa-solid').css('color', '#fe4d4d').addClass('like-animation'); // Liked
    } else {
        $(this).removeClass('fa-solid').addClass('fa-regular').css('color', '#ffffff').addClass('like-animation'); // Not liked
    }
    $.post('/api/like/like', {
        post_id: post_id
    }, function (data, textSuccess) {
        if (textSuccess == "success") {
            setTimeout(function () {
                $($this).removeClass('like-animation');
            }, 1000);
            if (data.liked) {
                $($this).removeClass('fa-regular').addClass('fa-solid').css('color', '#fe4d4d'); // Liked
            } else {
                $($this).removeClass('fa-solid').addClass('fa-regular').css('color', '#ffffff'); // Not liked
            }
        }

    });
});

$('.follow-user').on('click', function () {
    post_id = $(this).closest('.col-lg-4').attr('id').replace('post-', '');
    // console.log(post_id);
    $this = $(this);

    if ($(this).hasClass('fa-user-plus')) {
        $(this).removeClass('fa-user-plus').addClass('fa-user-minus');
        $(this).css('color', '#ffffff');
    } else {
        $(this).removeClass('fa-user-minus').addClass('fa-user-plus');
        $(this).css('color', '#74C0FC');
    }

    $.post('/api/follow/follow', {
        post_id: post_id
    }, function (data, textSuccess) {
        if (textSuccess == "success") {

        }

    });
});

$('.header-profile').on('click', function () {

    $.post('/api/follow/follower_count', {
        // post_id: post_id
    }, function (data, textSuccess) {
        if (textSuccess == "success") {
            $('#followers-count').text(data['message']);
        }
    });

    $.post('/api/follow/following_count', {
        // post_id: post_id
    }, function (data, textSuccess) {
        if (textSuccess == "success") {
            $('#following-count').text(data['message']);
        }
    });
});

// To get the followers list 
$('#followers-main').on('click', function () {
    $.post('/api/follow/followers_list', function (data, textStatus) {
        if (textStatus == "success") {
            $('#followers-list').empty();
            data.message.forEach(function (userId) {
                get_followers_Username(userId);
            });
            $('#followers-toggle').modal('show');
        }
    });
});

function get_followers_Username(userId) {
    $.post('/api/follow/follow_username', { userId: userId }, function(data, textStatus){
        if(textStatus == "success"){
            var listItem = $('<li>').text(data.message);
            $('#followers-list').append(listItem);
        }
    });
}
// To get the following list 
$('#following-main').on('click', function () {
    $.post('/api/follow/following_list', function (data, textStatus) {
        if (textStatus == "success") {
            $('#following-list').empty();
            data.message.forEach(function (userId) {
                get_following_Username(userId);
            });
            $('#following-toggle').modal('show');
        }
    });
});

function get_following_Username(userId) {
    $.post('/api/follow/follow_username', { userId: userId }, function(data, textStatus){
        if(textStatus == "success"){
            var listItem = $('<li>').text(data.message);
            $('#following-list').append(listItem);
        }
    });
};