<?php

class Subservices_API extends MY_Controller
{
  function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
    parent::requireLogin();
    $this->load->model('core/Session_model', 'Session');
    $this->load->model('subservice/Subservice_model', 'Subservices');
    $this->load->model('user/User_model', 'Users');
  }

  public function generateDatatable()
  {
    $select = "code, subservices.name, subservices.created, subservices.id as idsubservice";
    $join = ['services', 'priority'];
    $columnjoin = ['id_service', 'id_priority'];
    $as = 'services.name as service, priority.name as priority';
    echo $this->Subservices->generateDatatable($select, null, $join, $columnjoin, $as);
  }
}
