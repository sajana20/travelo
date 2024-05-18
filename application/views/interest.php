<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone.js"
    integrity="sha512-XMEyFFnkOtTcmham/KOEzTLqdZ3MmE9AYxWtwuGxiygMl7UgaZAn/+wdgdb5mAi/i5OpfDIGF+vZHTVpDfS2JA=="
    crossorigin="anonymous"></script>
<style>
    .interest-tag.selected {
        background: #8CA5F2 !important;
    }

    .category-container {
        background-color: #C6D3F7;
        border-radius: 4px;
    }

    .category-name {
        margin-top: 15px;
        margin-left: 10px;
        font-weight: 600;
    }

    .tag-container {
        margin-bottom: 15px;
    }

    .tag {
        margin-left: 10px;
        margin-bottom: 20px;
        margin-top: 20px;
    }
</style>
<div class="page-body">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div id="login-overlay" class="card shadow-lg">
            <div class="card-body">
                <div class="modal-header">
                    <h4 class="modal-title mt-3">What are your interest</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="well">
                                <div class="category-container">
                                    <div class="category-name">
                                        <div>Adventure Travel</div>
                                    </div>
                                    <div class="tag-container">
                                        <span class="interest-tag badge bg-light text-dark tag">Rock Climbing</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Water Sports</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Skydiving</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Safari </span>
                                    </div>

                                </div>
                                <div class="category-container">
                                    <div class="category-name">
                                        <div>Camping</div>
                                    </div>
                                    <div class="tag-container">
                                        <span class="interest-tag badge bg-light text-dark tag">Tent Camping</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Campfire Cooking</span>
                                        <span class="interest-tag badge bg-light text-dark tag">RV Camping</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Solo Camping</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Family Camping</span>
                                    </div>
                                </div>

                                <div class="category-container">
                                    <div class="category-name">
                                        <div>Luxury Travel</div>
                                    </div>
                                    <div class="tag-container">
                                        <span class="interest-tag badge bg-light text-dark tag">Boutique Hotels</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Luxury Resorts</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Spa Retreats</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Fine Dining
                                            Experiences</span>
                                    </div>
                                </div>


                                <div class="category-container">
                                    <div class="category-name">
                                        <div>Wildlife</div>
                                    </div>
                                    <div class="tag-container">
                                        <span class="interest-tag badge bg-light text-dark tag">Wildlife
                                            Photography</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Bird Watching</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Wildlife
                                            Sanctuaries</span>
                                        <span class="interest-tag badge bg-light text-dark tag">National Parks</span>
                                    </div>
                                </div>


                                <div class="category-container">
                                    <div class="category-name">
                                        <div>Road Trips</div>
                                    </div>
                                    <div class="tag-container">
                                        <span class="interest-tag badge bg-light text-dark tag">Scenic Drives</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Road Trip Games</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Car Rental</span>
                                        <span class="interest-tag badge bg-light text-dark tag">Road Trip
                                            Adventure</span>
                                    </div>
                                </div>
                                <button id="interestButton" type="submit" class="btn btn-success btn-block">
                                    Done
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var selectedInterests = [];

    $(".interest-tag").click(function (e) {
        $(this).toggleClass('selected')

        var selected = $(this).hasClass('selected');
        var tag = $(this).html();
        console.log('selected', selected)
        if (selected) {
            selectedInterests.push(tag)
        } else {
            const index = selectedInterests.indexOf(tag);

            if (index > -1) { // only if tag already exists
                selectedInterests.splice(index, 1);
            }
        }
    })

    $('#interestButton').click(function () {
        setInterest();
    })

    function setInterest() {

        var userId = sessionStorage.getItem("user")
        var InterestModel = Backbone.Model.extend(
            {
                urlRoot: '<?php echo base_url('index.php/api/UserController/interest') ?>',
            }
        )

        var interest = new InterestModel();
        var formData = new FormData();
        formData.append('user_id', userId);
        formData.append('selectedInterests', selectedInterests);

        interest.save(formData, {
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (u) {
                window.location = '<?php echo base_url('index.php/page/post') ?>';
            }
        });

    }

</script>