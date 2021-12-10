<?php

class Subservices extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
  }

  public function list_all()
  {
    $data['title'] = 'List All Sub Services';
    $data['link'] = base_url('API/Subservices/generateDatatable');
    $this->render('subservice/list_all', $data);
  }
}
