<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone.js"
    integrity="sha512-XMEyFFnkOtTcmham/KOEzTLqdZ3MmE9AYxWtwuGxiygMl7UgaZAn/+wdgdb5mAi/i5OpfDIGF+vZHTVpDfS2JA=="
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

<style>
    .like-btn {
        height: 30px;
        width: 30px;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .comment-btn {
        height: 30px;
        width: 30px;
    }

    .post-container {

        background-color: #dee2e6;
        border-radius: 4px;
        margin-top: 15px;

    }

    .comment-wrapper {
        background-color: #dee2e6;
        border-radius: 4px;
    }

    .main-content {
        position: fixed;
        left: 250px;
        height: 100vh;
        overflow-y: auto;
        padding: 0 200px;
    }

    .liked {

        background-image: url(<?php echo base_url('/assets/images/likedBtn.png'); ?>);
    }

    .disliked {

        background-image: url(<?php echo base_url('/assets/images/likeBtn.png'); ?>);
    }

    .post-container .full-name {
        font-weight: 700;
        font-size: 20px;
        margin-top: 12px;
    }

    .post-container .description {
        font-size: 15px;
        margin-bottom: 10px;
    }

    .post-container .tag {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 10px;
    }

    #viewComments .full-name {
        font-weight: 700;
        font-size: 18px;

    }

    #viewComments .date-posted {
        font-weight: 600;
        font-size: 14px;
        color: #ADB2BE;

    }

    #viewAllCommentForm .full-name {
        font-weight: 700;
        font-size: 15px;
        margin-left: 8px;

    }

    #viewAllCommentForm .comment {

        font-size: 14px;
        margin-left: 8px;

    }
</style>

<div class="main-content">
    <?php include 'create_post.php'; ?>
    <div id="postContainerWrapper" class="container">
        <div id="postContainer">
            <div class="row">

            </div>

        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="viewComments">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">All Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="postDetails">
                    <p class="full-name"></p>
                    <p class="date-posted"> </p>
                    <img src="" class="card-img-top image" alt="Image">
                    <p class="like-count"> </p>
                </div>
                <div id="viewAllCommentForm">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var posts;
    var userId = sessionStorage.getItem("user")
    loadPost('<?php echo base_url('index.php/api/PostController/posts/') ?>' + userId)

    function generateTagContent(tagString){
        var content = '';
        tagString.split(",").forEach(tag => {
            content+= `<div class="badge bg-light text-dark tag me-1">${tag}</div>`
            
        });
        return content

    }

    function loadPost(url) {
        var PostModel = Backbone.Model.extend({
            urlRoot: url,
            idAttribute: 'post_id',
            defaults: {
                post_id: "",
                description: "",
                date_posted: "",
                image: ""
            }
        });

        var postsModel = new PostModel();


        var PostCollection = Backbone.Collection.extend({
            model: PostModel,
            url: url,
        })

        posts = new PostCollection();

        var PostView = Backbone.View.extend({

            model: posts,
            el: $('#postContainerWrapper'),
            initialize: function () {
                posts.fetch({ async: false })
                this.render();
                this.model.on('add', this.render, this);
                this.model.on('change', this.render, this);
            }
            , render: function () {
                var self = $('#postContainer .row');
                self.html('');
                posts.forEach(function (post) {
                    var row = `
                <div class="col-12 post-container">
                    <div class="full-name">${post.get('full_name')}</div>
                    <div class="description">${post.get('description')}</div>
                    
                    <div>${generateTagContent( post.get('tag'))}</div>
                    <img src="<?php echo base_url() ?>${post.get('image')}" class="card-img-top" alt="Image">
                    <div class="d-flex mt-3">
                    <div class="like-btn ${post.get('liked') == 1 ? 'liked' : 'disliked'} like-button-new" data-post_id="${post.get('post_id')}" id= "likeButton${post.get('post_id')}" 
                            class="card-img-top" alt="Like-btn"> </div>
                        <img onclick="viewAllcomments('${btoa(JSON.stringify(post.toJSON()))}')" class="comment-btn ms-5" data-bs-toggle="modal" data-bs-target="#viewComments"src="<?php echo base_url('/assets/images/comment.png'); ?>"
                            class="card-img-top" alt="Comment-btn">

                    </div>
                    <div id = "likeCount${post.get('post_id')}">${post.get('like_count') ? post.get('like_count') + " likes" : ""} </div>

                    <button onclick="viewAllcomments('${btoa(JSON.stringify(post.toJSON()))}')" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#viewComments">View all comments</button>
                    <div class= "d-flex  mb-3">
                        <input type="text" class="form-control comment-input" id="comment${post.get('post_id')}" name="comment"
                        placeholder="Write a comment" aria-label=Write a comment" aria-describedby="basic-addon2">
                        <button id="comment${post.get('post_id')}btn" onClick="onComment('${post.get('post_id')}')" type="button" class="btn btn-primary ms-1" disabled>Comment</button>
                        
                    </div>
                </div>
            `
                    self.append(row);
                });
            },
            events: {
                "click .like-button-new" : "onLikeClick"
            },
            onLikeClick: function(e) {
                var status;
                var newLikeCount;
                var postId = $(e.currentTarget).data('post_id');
                var userId = sessionStorage.getItem("user");
                var postToEdit = posts.get(postId);
                
                var likeCount = postToEdit.get('like_count');
                if ($("#likeButton" + postId).hasClass("disliked")) {

                    status = true
                    newLikeCount = likeCount + 1;
                } else {
                    status = false;
                    newLikeCount = likeCount != 1 ? (likeCount - 1) : 0;
                }

                postToEdit.set({'like_count': newLikeCount, 'status': status, 'post_id': postId, 'user_id': userId, liked: status})

                postToEdit.save({}, {
                    data: jsonObjectToFormData(postToEdit.toJSON()), contentType: false,processData:false,
                    url: '<?php echo base_url('index.php/api/PostController/posts_like') ?>', async: false,
                    emulateHTTP: true
                });

            }
        });

        new PostView();
    }

   

    function jsonObjectToFormData(obj) {
    var formData = new FormData();
    
    for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
            formData.append(key, obj[key]);
        }
    }
    
    return formData;
}

    function clearSearch() {
        $('#searchPost').val('')
        loadPost('<?php echo base_url('index.php/api/PostController/posts/') ?>' + userId)
        $('#clearSearch').hide()
    }

    function viewAllcomments(post) {

        var postData = JSON.parse(atob(post));
        $('#postDetails .full-name').html(postData.full_name)
        $('#postDetails .date-posted').html(postData.date_posted)
        $('#postDetails .image').attr("src", '<?php echo base_url() ?>' + postData.image)
        $('#postDetails .like-count').html(postData.like_count ? postData.like_count + ' likes' : "")
        var CommentModel = Backbone.Model.extend({
            urlRoot: '<?php echo base_url('index.php/api/PostController/comment/') ?>' + postData.post_id,
            defaults: {
                id: "",
                user_id: "",
                post_id: "",
                comment: ""
            }
        });

        var commentModel = new CommentModel();


        var CommentCollection = Backbone.Collection.extend({
            model: CommentModel,
            url: '<?php echo base_url('index.php/api/PostController/comment/') ?>' + postData.post_id,
        })

        var comments = new CommentCollection();

        var CommentView = Backbone.View.extend({

            model: comments,
            el: $('#viewAllCommentForm'),
            initialize: function () {
                comments.fetch({ async: false })
                this.render();
            }
            , render: function () {
                var self = $('#viewAllCommentForm .row');
                self.html('');
                comments.forEach(function (comment) {

                    var row = `
                    <ul class="list-group list-group-flush">
                        
                        <li class="list-group-item">
                        <div class="comment-wrapper">
                        <div class="full-name">${comment.get('full_name')}</div>
                        <div class="comment">${comment.get('comment')}</div>
                        </div>
                            <hr>      
                        </li>                       
                    </ul>
                    
            `
                    self.append(row);
                });

            }

        });

        new CommentView();

    }


    function onComment(postId) {
        var CommentModel = Backbone.Model.extend(
            {
                urlRoot: '<?php echo base_url('index.php/api/PostController/comment') ?>',
            }
        )

        var comment = new CommentModel();
        var formData = new FormData();
        formData.append('user_id', userId);
        formData.append('post_id', postId);
        formData.append('comment', $('#comment' + postId).val())

        comment.save(formData, {
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (u) {
                $('#comment' + postId).val("")
            }
        });
    }

    $(".comment-input").keyup(function(e){
        var el = $(e.currentTarget);
        $(`#${el.attr('id')}btn`).prop('disabled', el.val().length == 0);
    });

</script>