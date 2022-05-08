<?php

class Services extends MY_Controller
{
  function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
    parent::requireLogin();
    $this->load->model('core/Session_model', 'Session');
    $this->load->model('service/Service_model', 'Services');
    $this->load->model('user/User_model', 'Users');
  }

  public function generateDatatable()
  {
    $select = "id, name, created";
    echo $this->Services->generateDatatable($select, null, null, null, null);
  }
}
