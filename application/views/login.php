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
		.login-container {
			background-color: #dee2e6 ;
		}

		input {
			min-width: 300px;
		}
		
	</style>

<div class="page-body login-container">
	<?php 
	$version = phpversion();
	log_message('info', 'version:'.$version) ;?>
	<div class="h-100 d-flex align-items-center justify-content-center">
		<div id="login-overlay" class="card shadow-lg">
			<div class="card-body">
				<div class="modal-header">
					<h4 class="modal-title title">Welcome to Travelo</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="mt-5">
								<form id="loginForm" class="d-flex flex-column">
									<div class="form-group">
										<label for="email" class="control-label">Email</label>
										<input type="text" class="form-control" id="email" name="email" value=""
											required="" title="Please enter you email">
										<span class="help-block"></span>
									</div>
									<div class="form-group">
										<label for="password" class="control-label">Password</label>
										<input type="password" class="form-control" id="password" name="password"
											value="" required="" title="Please enter your password">
										<span class="help-block"></span>
									</div>
									<div id="loginErrorMessage" class="alert alert-error hide text-danger"></div>


									<button id="loginButton" type="submit" class="btn btn-block mt-5 btn-success">Login
									</button>
									<a href="<?php echo base_url('index.php/page/register') ?>" class="btn font-weight-light btn-block align-center  mb-2 
									text-grey">New to Travelo? <span class="text-primary
									font-weight-bold">Register</span>
									</a>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script>

	$('#loginButton').click(function (e) {
		e.preventDefault()
		loginUser();
	})

	function loginUser() {


		var UserModel = Backbone.Model.extend(
			{
				urlRoot: '<?php echo base_url('index.php/api/AuthController/login') ?>',
			}
		)

		var user = new UserModel();
		var formData = new FormData(document.querySelector("#loginForm"));
		user.save(null, {
			data: formData,
			contentType: false,
			processData: false,
			async: false,
			success: function (user) {
				sessionStorage.setItem("user", user.id);
				checkUserInterest();

			},
			error: function (e) {
				$('#loginErrorMessage').html('Invalid credentials');
			}
		});
	}

	function checkUserInterest() {
		var userId = sessionStorage.getItem("user")
		var UserModel = Backbone.Model.extend(
			{
				urlRoot: '<?php echo base_url('index.php/api/UserController/interest/') ?>' + userId,
			}
		)

		var user = new UserModel();
		user.fetch({

			success: function (response) {

				if (response.get('has_interest') == 1) {
					window.location = '<?php echo base_url('index.php/page/post') ?>';
				} else

					window.location = '<?php echo base_url('index.php/page/interest') ?>';

			}
		});
	}

</script>