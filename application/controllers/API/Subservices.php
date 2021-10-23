<?php

class Subservices extends MY_Controller
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
    $select = "code, subservices.name, priority, subservices.created, subservices.id as idsubservice";
    $action = [true, "#", 'idsubservice'];
    $join = ['services'];
    $columnjoin = ['id_service'];
    $as = 'services.name as service';
    echo $this->Subservices->generateDatatable($select, null, $join, $columnjoin, $as, $action);
  }
}
