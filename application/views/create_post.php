<style>
  .creat-post-container {

    background-color: #dee2e6;
    border-radius: 4px;
  }

  .photo-btn {
    background-color: royalblue;
  }


  .btn-container {
    margin-bottom: 35px;
  }

  .add-image-icon {
    height: 100px;
    width: 100px;
    margin: auto;

  }

  .add-image-container {
    background-color: powderblue;
    border-radius: 4px;
    height: 400px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
  }

  .modal-backdrop {
    z-index: -1 !important;
  }

  .search-bar {
    float: right;
    padding: 6px;
    border: none;
    margin-top: 8px;
    margin-right: 16px;
    font-size: 17px;
  }
</style>

<div class="container creat-post-container">
  <div class="row mt-3">
    <div class="col">
      <div class="ui-widget mt-3 mb-3">

        <input type="text" class="form-control" id="searchPost" name="searchPost" placeholder="Search Post"
          aria-label="searchPost" aria-describedby="basic-addon2">
        <button id="clearSearch" type="button" class="btn btn-primary mx-auto mt-3 " onclick="clearSearch()">Clear
          Search</button>
      </div>
    </div>
  </div>
  <div class="row mb-3 btn-container">
    <div class="col-12">
      <div class="d-flex">

        <button onclick="onAddClick()" type="button" class="btn photo-btn btn-primary mb-3" data-bs-toggle="modal"
          data-bs-target="#createPost">Photo</button>
      </div>

    </div>

  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="createPost">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createPostForm">
          <div class="form-group input-group mb-3 mt-3">
            <input type="text" class="form-control" id="description" name="description"
              placeholder="What's on your mind?" aria-label="What's on your mind?" aria-describedby="basic-addon2">
          </div>
          <div id="displayTags"></div>
          <div class="ui-widget mt-3 mb-3">
            <label for="addTags">Add tags: </label>
            <input id="addTags">
          </div>
          <div class="form-group d-flex add-image-container" onclick="onaddImage(event)">
            <input type="file" class="form-control custom-file-input d-none" id="fileInput" name="file" accept="image/*"
              onchange="readURL(this);">
            <img class="add-image-icon" src="<?php echo base_url('/assets/images/add_image.png'); ?>"
              class="card-img-top" alt="Add-image">
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-primary mx-auto px-5" onclick="onclickPost()">Post</button>
      </div>
    </div>
  </div>
</div>


<script>
  $('#clearSearch').hide()

  var availableTags = [
    "Rock Climbing",
    "Water Sports",
    "Skydiving",
    "Safari",
    "Tent Camping",
    "Campfire Cooking",
    "RV Camping",
    "Solo Camping",
    "Family Camping",
    "Boutique Hotels",
    "Luxury Resorts",
    "Spa Retreats",
    "Fine Dining Experiences",
    "Wildlife Photography",
    "Bird Watching",
    "Wildlife Sanctuaries",
    "National Parks",
    "Scenic Drives",
    "Road Trip Games",
    "Car Rental",
    "Road Trip Adventure"
  ];

  var tags = [];



  function onAddClick() {

    tags = []
    $('#displayTags').html('')
    $("#addTags").autocomplete({
      source: availableTags,
      select: function (e, ui) {

        tags.push(ui.item.value);

        setTimeout(() => { $(this).val('') });

        var dispalyContent = "";

        tags.forEach(tag => {
          dispalyContent += `<span class="badge bg-light text-dark">${tag}</span>`

        });
        $('#displayTags').html(dispalyContent)
      }
    }
    );
  }

  function onaddImage(event) {
    event.stopPropagation();
    document.getElementById("fileInput").click()
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('.add-image-container').css('background-image', 'url("' + e.target.result + '")');
        $('.add-image-icon').css('display', 'none');
      };

      reader.readAsDataURL(input.files[0]);
    }
  }


  function onclickPost() {
    var userId = sessionStorage.getItem("user")
    var CreatePostModel = Backbone.Model.extend(
      {
        urlRoot: '<?php echo base_url('index.php/api/PostController/save') ?>',
      }
    )

    var createPostModel = new CreatePostModel();
    var formData = new FormData(document.querySelector("#createPostForm"));
    formData.append('user_id', sessionStorage.getItem("user"))
    formData.append('add_tags', tags)
    createPostModel.save(formData, {
      data: formData,
      contentType: false,
      processData: false,
      async: false,
      success: function (u) {
        loadPost('<?php echo base_url('index.php/api/PostController/posts/') ?>' + userId)
        $('#createPost').modal('hide');

      }
    });
  }

</script>