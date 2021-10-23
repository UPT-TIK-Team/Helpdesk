<?php

class Subservices extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
  }

  public function list()
  {
    $data['title'] = 'List All Sub Services';
    $data['link'] = base_url('API/Subservices/generateDatatable');
    $this->render('subservice/subservice_views', $data);
  }
}
