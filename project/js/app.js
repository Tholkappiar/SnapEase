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

$('.btn-delete').on('click',function(){
    post_id = $(this).parent().attr('data-id');
    d = new Dialog("Delete Post", "Are you sure want to remove this post");

    d.setButtons([
        {
            'name': "Delete",
            "class": "btn-danger",
            "onClick": function(event){
                console.log(post_id);

                $.post('/api/post/delete',{
                    id: post_id
                },function(data,textSuccess){
                    if(textSuccess =="success" ){ //means 200
                        $(`#post-${post_id}`).remove();
                    }
                })
                $(event.data.modal).modal('hide');
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
})