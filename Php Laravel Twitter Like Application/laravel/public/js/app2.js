var postId=0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click' , function() {
    event.preventDefault();
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = event.target.parentNode.parentNode.childNodes[1].textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});

$('#modal-save').on('click' , function() {
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: { body: $('#post-body').val(), postId: postId, _token: token}
    })
        .done(function (msg) {
            $(postBodyElement).text(msg['new_body']);
            $('#edit-modal').modal('hide');
        });
});


$('.like').on('click',function(event){
    //console.log(isLike);
    event.preventDefault();
    postId = event.target.parentNode.parentNode.dataset['postid'];
    var isLike = event.target.previousElementSibling == null; //daca nu avem elem inainte inseamna ca am dat like daca nu am dat dislike
    $.ajax({
        method: 'POST',
        url: urlLike,
        data: {isLike: isLike, postId: postId, _token: token}
    })
        .done(function () {
            //Schimb textu cand dau like sau dislike
            event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'Liked' : 'Like' :
                event.target.innerText== 'Dislike' ? 'Disliked' : 'Dislike';
            if(isLike)
            {
                event.target.nextElementSibling.innerText = 'Dislike';
            }
            else
            {
                event.target.previousElementSibling.innerText = 'Like';
            }
        });
});



