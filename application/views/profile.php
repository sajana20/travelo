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
    .main-content {
        position: fixed;
        left: 250px;
        height: 100vh;
        overflow-y: auto;
        padding: 0 200px;
        width: calc(100% - 250px);
    }

    .liked {

        background-image: url(<?php echo base_url('/assets/images/likedBtn.png'); ?>);
    }

    .disliked {

        background-image: url(<?php echo base_url('/assets/images/likeBtn.png'); ?>);
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

    .like-btn {
        height: 30px;
        width: 30px;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .user-detail-container {

        background-color: #dee2e6;
        border-radius: 4px;
    }
    .user-detail-container .user-name {

        font-weight: 600;
        font-size: 40px;
    }

    .like-btn {
        height: 30px;
        width: 30px;
    }

    .comment-btn {
        height: 30px;
        width: 30px;
    }

    .comment-wrapper {
        background-color: #dee2e6;
        border-radius: 4px;
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

<div class="modal" tabindex="-1" role="dialog" id="editProfileBtn">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <label for="fullName" class="control-label">Full Name</label>
                <div id="profileDetails">
                    <input type="text" class="form-control" id="fullName" name="fullName" value="" required=""
                        title="Full Name">
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-primary mx-auto px-5" id="saveProfile" onclick="saveProfile()">Save</button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="main-content">

    <div class="user-detail-container">
        <div class="row">
            <div class="d-flex">
                <p class="user-name ms-2"></p>
                <div class = "my-auto ms-auto me-2">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editProfileBtn">Edit Profile</button>
                </div>
               

            </div>

        </div>
    </div>
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
                    <p class="like-count mt-2"> </p>
                </div>
                <div id="viewAllCommentForm">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="editPost">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editPostDetails">
                    <p id="fullNamePost"></p>
                    <label for="description" class="control-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="" required=""
                        title="Please enter you email">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mx-auto px-5" id="savePost">Save</button>
                    </div>

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

    var userId = sessionStorage.getItem("user")

    var UserModel = Backbone.Model.extend(
        {
            urlRoot: '<?php echo base_url('index.php/api/UserController/profile/') ?>' + userId,
        }
    )

    var user = new UserModel();
    user.fetch({

        success: function (response) {
            
            $(".user-detail-container .user-name").html(response.get('full_name'));
            $("#profileDetails #fullName").val(response.get('full_name'));


        }
    });

    function saveProfile() {
         
        user.set({'full_name': $("#fullName").val() })
        var formData = jsonObjectToFormData(user.toJSON())
        user.save(formData, {
                    data: formData, contentType: false,processData:false,async: false,
                    
                    success: function (u) {
                        $('#editProfileBtn').modal('hide');
                        $(".user-detail-container .user-name").html($("#fullName").val()) 
                        loadPost('<?php echo base_url('index.php/api/PostController/user_posts/') ?>' + userId)     
                    } 
        })

        
    }

    loadPost('<?php echo base_url('index.php/api/PostController/user_posts/') ?>' + userId)

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

        var posts = new PostCollection();

        var PostView = Backbone.View.extend({

            model: posts,
            el: $('body'),
            initialize: function () {
                posts.fetch({ async: false })
                this.render();
                this.model.on('add', this.render, this);
                this.model.on('change', this.render, this);
                this.model.on('remove', this.render, this);
            }
            , render: function () {
                var self = $('#postContainer .row');
                self.html('');
                posts.forEach(function (post) {
                    var row = `
                <div class="col-12 post-container ">

                <div class="d-flex">
                
                    <div class="my-auto full-name">${post.get('full_name')}</div>

                    <div class="dropdown my-auto ms-auto">
                        <div id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                <path
                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                            </svg>
                        </div>

            

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <span onclick ="onEditPost('${btoa(JSON.stringify(post.toJSON()))}')"class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#editPost" >Edit Post</span>
                            <span onclick ="onDeletePost('${post.get('post_id')}')" id="deletePost"class="dropdown-item" >Delete Post</span>
                        </div>
                    </div>

                    </div>

                    <div class= "description">${post.get('description')}</div>
                    <div>${generateTagContent(post.get('tag'))}</div>
                    <img src="<?php echo base_url() ?>${post.get('image')}" class="card-img-top" alt="Image">
                    <div class="d-flex mt-2">
                    <div class="like-btn ${post.get('liked') == 1 ? 'liked' : 'disliked'}" data-post_id="${post.get('post_id')}" id= "likeButton${post.get('post_id')}" 
                            class="card-img-top" alt="Like-btn"> </div>
                        <img onclick="viewAllcomments('${btoa(JSON.stringify(post.toJSON()))}')" class="comment-btn ms-5" data-bs-toggle="modal" data-bs-target="#viewComments"src="<?php echo base_url('/assets/images/comment.png'); ?>"
                            class="card-img-top" alt="Comment-btn">

                    </div>
                    <div id = "likeCount${post.get('post_id')}">${post.get('like_count') ? post.get('like_count') + " likes" : ""} </div>

                    <button onclick="viewAllcomments('${btoa(JSON.stringify(post.toJSON()))}')" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#viewComments">View all comments</button>
                    <div class= "d-flex  mb-3">
                        <input type="text" class="form-control comment-input" id="comment${post.get('post_id')}" name="comment"
                        placeholder="Write a comment" aria-label=Write a comment" aria-describedby="basic-addon2">
                        <button onClick="onComment('${post.get('post_id')}')" id="comment${post.get('post_id')}btn" type="button" class="btn btn-primary ms-1" disabled>Comment</button>
                        
                    </div>
                </div>
            `
                    self.append(row);
                });
            },
            events: {
                "click #savePost": 'editPost',
                "click #deletePost": 'deletePost',
                "click .like-btn" : "onLikeClick"
            },
            editPost: function (e) {
                var postId = $(e.currentTarget).data('post_id');
                var postToEdit = posts.get(postId)

                postToEdit.set({
                    "description": $('#editPost #description').val(),

                });

                postToEdit.save({}, {
                    data: jsonObjectToFormData(postToEdit.toJSON()), contentType: false,processData:false,
                    emulateHTTP: true,
                    url: '<?php echo base_url('index.php/api/PostController/user_posts/') ?>'+userId});
                    $('#editPost').modal('hide');
            },
            deletePost: function(e){
                var postId = $(e.currentTarget).data('post_id');
                var postToDelete = posts.get(postId);
                postToDelete.destroy()
			    posts.remove(postToDelete);
                
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

    function clearSearch() {
    $('#searchPost').val('')
    loadPost('<?php echo base_url('index.php/api/PostController/user_posts/') ?>' + userId)
    $('#clearSearch').hide()
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

    function onEditPost(post) {
        var postData = JSON.parse(atob(post));
        $("#editPost #fullNamePost").html(postData.full_name)
        var editedDescription = $("#editPost #description").val(postData.description)
        var editedImage = $('#editPost #image').attr("src", '<?php echo base_url() ?>' + postData.image)
        $("#savePost").data("post_id", postData.post_id)
    }

    function onDeletePost(postId){
        $("#deletePost").data("post_id", postId)
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

    function generateTagContent(tagString){
        var content = '';
        tagString.split(",").forEach(tag => {
            content+= `<div class="badge bg-light text-dark tag me-1">${tag}</div>`
            
        });
        return content

    }

    $("#searchPost").autocomplete({
    source: availableTags,
    select: function (e, ui) {
      var userId = sessionStorage.getItem("user")
      var searchTag = (ui.item.value);
      loadPost('<?php echo base_url('index.php/api/PostController/user_posts/') ?>' + userId + "?search_key=" + searchTag)
      $('#clearSearch').show()


    }
  });

    $(".comment-input").keyup(function(e){
        var el = $(e.currentTarget);
        $(`#${el.attr('id')}btn`).prop('disabled', el.val().length == 0);
    });

</script>