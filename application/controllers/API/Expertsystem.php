<?php

class Expertsystem extends MY_Controller
{
  function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
    parent::requireLogin();
    $this->load->model('core/Session_model', 'Session');
    $this->load->model('expertsystem/Gejala_model', 'Gejala');
    $this->load->model('user/User_model', 'Users');
  }
}
