<?php

require APPPATH . "libraries/RestController.php";
use chriskacerguis\RestServer\RestController;

class UserController extends RestController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserAccountModel');
	}

	public function interest_post()
	{
		$user = $this->UserAccountModel->addInterest($this->input->post());
		$this->set_response(json_encode($user), RESTController::HTTP_OK);

	}

	public function interest_get()
	{

		$userId = $this->uri->segment(4);
		$hasInterest = $this->UserAccountModel->hasInterests($userId);
		$this->set_response(json_encode($hasInterest), RESTController::HTTP_OK);
	}

	public function profile_get()
	{

		$userId = $this->uri->segment(4);
		$user = $this->UserAccountModel->findUserById($userId);
		$this->set_response(json_encode($user), RESTController::HTTP_OK);

	}

	public function profile_post()
	{
		$userId = $this->uri->segment(4);
		$this->UserAccountModel->updateUserProfile($this->input->post(), $userId);
		$this->set_response(json_encode(['status'=> "success"]), RESTController::HTTP_OK);


	}

}

