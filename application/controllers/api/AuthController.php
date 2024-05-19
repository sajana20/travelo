<?php

require APPPATH . "libraries/RestController.php";
use chriskacerguis\RestServer\RestController;

class AuthController extends RestController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserAccountModel');
	}

	public function login_post()
	{

		$email = $this->post('email');

		$user = $this->UserAccountModel->findUserByEmail($email);
		if ($user) {

			if (password_verify($this->post('password'), $user->password)) {
				$this->response(
					json_encode(
						[
							'id' => $user->id,
							'full_name' => $user->full_name,
							'email' => $user->email
						]
					),
					RESTController::HTTP_OK
				);
			} else {
				$this->response("Incorrect password", RESTController::HTTP_UNAUTHORIZED);
			}
		} else {
			$this->response("User does not exist", RESTController::HTTP_UNAUTHORIZED);
		}
	}

	public function register_post()
	{


		$data = [
			'full_name' => $this->post('full_name'),
			'email' => $this->post('email'),
			'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
		];

		$user = $this->UserAccountModel->addUser($data);
		$this->set_response(json_encode(['status'=> $user]), RESTController::HTTP_CREATED);
	}

}

