<?php

require APPPATH . "libraries/RestController.php";
use chriskacerguis\RestServer\RestController;

class PostController extends RestController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('PostModel');
		$this->load->helper('form');
	}

	public function save_post()
	{
		$user = $this->PostModel->savePosts($this->input->post());
		$this->set_response(json_encode(['status'=> $user]), RESTController::HTTP_CREATED);


	}

	public function posts_get()
	{
		$userId = $this->uri->segment(4);
		$searchTag = $this->input->get('search_key');
		if ($searchTag) {
			$posts = $this->PostModel->loadAllPostBySearchKey($userId, $searchTag);
			$this->set_response(json_encode($posts), RESTController::HTTP_OK);

		} else {
			$posts = $this->PostModel->loadAllPost($userId);
			$this->set_response(json_encode($posts), RESTController::HTTP_OK);
		}

	}

	public function user_posts_get()
	{
		$userId = $this->uri->segment(4);
		$searchTag = $this->input->get('search_key');

		if($searchTag){
			$posts = $this->PostModel->loadAllUserPostBySearchKey($userId, $searchTag);
			$this->set_response(json_encode($posts), RESTController::HTTP_OK);
		} else {
			$posts = $this->PostModel->loadPostByUserId($userId);
		$this->set_response(json_encode($posts), RESTController::HTTP_OK);
		}	

	}

	public function user_posts_put()
	{
		$this->PostModel->updatePostDetails($this->input->post());
		$this->response('success', RESTController::HTTP_OK);
	}

	public function user_posts_delete()
	{
		$postId = $this->uri->segment(5);
		$this->PostModel->deletePost($postId);
		$this->response('post deleted', RESTController::HTTP_OK);
	}

	public function comment_get()
	{
		$postId = $this->uri->segment(4);
		$comments = $this->PostModel->loadAllComment($postId);
		$this->set_response(json_encode($comments), RESTController::HTTP_OK);


	}

	public function comment_post()
	{
		$comments = $this->PostModel->saveComment($this->input->post());
		$this->set_response(json_encode($comments), RESTController::HTTP_OK);


	}

	public function posts_like_put()
	{
		$postId = $this->input->post('post_id');
		$userId = $this->input->post('user_id');
		$status = $this->input->post('status');
		$likeCount = $this->PostModel->updateLikedPost($postId, $userId, $status);
		$this->set_response(json_encode($likeCount), RESTController::HTTP_OK);


	}

}

