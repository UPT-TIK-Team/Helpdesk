<?php

class Services extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
  }

  public function list_all()
  {
    $data['title'] = 'List All Services';
    $data['link'] = base_url('API/Services/generateDatatable');
    $this->render('service/list_all', $data);
  }
}
