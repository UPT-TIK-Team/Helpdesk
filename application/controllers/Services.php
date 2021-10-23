<?php

class Services extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
  }

  public function list()
  {
    $data['title'] = 'List All Services';
    $data['link'] = base_url('API/Services/generateDatatable');
    $this->render('service/service_views', $data);
  }
}
