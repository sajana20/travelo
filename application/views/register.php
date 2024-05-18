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
		.register-container {
			background-color: #AFFEFF ;
		}
		input {
			min-width: 300px;
		}
	</style>
<div class="page-body register-container">
	<div class="h-100 d-flex align-items-center justify-content-center">
		<div id="login-overlay" class="card shadow-lg">
			<div class="card-body">
				<div class="modal-header">
					<h4 class="modal-title mt-3">Register</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="well">
								<form id="registrationForm" class="d-flex flex-column ">
									<div class="form-group">
										<label for="full_name" class="control-label">Full Name</label>
										<input type="text" class="form-control" id="full_name" name="full_name"
											value="">
										<small><?php echo form_error('full_name'); ?></small>
										<span class="help-block"></span>
									</div>
									<div class="form-group">
										<label for="email" class="control-label">Email</label>
										<input type="text" class="form-control" id="email" name="email" value="" required="" title="Please enter you email">
										<small><?php echo form_error('email'); ?></small>
										<span class="help-block"></span>
									</div>
									<div class="form-group">
										<label for="password" class="control-label">Password</label>
										<input type="password" class="form-control" id="password" name="password">
										<small><?php echo form_error('password'); ?></small>

										<span class="help-block"></span>
									</div>
									<div class="form-group">
										<label for="confirm_password" class="control-label">Confirm Password</label>
										<input type="password" class="form-control" id="confirm_password"
											name="confirm_password">
										<small><?php echo form_error('confirm_password'); ?></small>

										<span class="help-block"></span>
									</div>
									<div id="errorMsg" class="alert alert-error hide text-danger"></div>
									<button id="registerButton" type="submit" class="btn btn-success btn-block mt-5">
										Register
									</button>
									<a href="<?php echo base_url('index.php/page/login') ?>" class="btn btn-block mb-2 font-weight-light
									text-grey">Already have an account? <span class="text-primary
									font-weight-bold">Login</span>
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

<script>

	$('#registerButton').click(function (e) {
		e.preventDefault()
		registerUser();
	})

	function registerUser() {
		
		var formData = new FormData(document.querySelector("#registrationForm"));

		if(isValidInput(formData)) {
			if (checkpassword()) {
			var UserModel = Backbone.Model.extend(
				{
					urlRoot: '<?php echo base_url('index.php/api/AuthController/register') ?>',
				}
			)

			var user = new UserModel();

			user.save(formData, {
				data: formData,
				contentType: false,
				processData: false,
				async: false,
				success: function (u) {
					window.location = '<?php echo base_url('index.php/page/login') ?>';
				}
			});
		} else {
			$('#errorMsg').html("The password entered for confirmation does not match")
		}
		}
	}

	function checkpassword() {
		return $('#password').val() === $('#confirm_password').val();
	}

	function isValidInput(formData) {
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		var displayNames = {
			'full_name': 'Full name',
			'email': 'Email',
			'password': 'Password',
			'comfirm_password': 'Comfirm password'
		};
		for(var pair of formData.entries()){
			if(!pair[1]) {
				$('#errorMsg').html(displayNames[pair[0]] + " required");
				return false;
			} else if (pair[0] == 'email') {
				if(!emailRegex.test(pair[1])) {
					$('#errorMsg').html('Invalid email address');
					return false;
				}
			}
    	}
		return true;
	}

</script>