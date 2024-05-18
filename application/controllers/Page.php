<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Page extends CI_Controller
{

    public function index()
    {
        redirect('/page/login');
    }

    public function register()
    {
        $this->load->view('register');
    }
    public function login()
    {
        $this->load->view('login');
    }

    public function Post()
    {
        $this->load->view('templates/nav');
        $this->load->view('post');
    }

    public function Profile()
    {
        $this->load->view('templates/nav');
        $this->load->view('profile');
    }
    public function interest()
    {

        $this->load->view('interest');
    }

}
