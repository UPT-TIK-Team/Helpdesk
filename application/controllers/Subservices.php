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
    $data['title'] = 'Daftar Seluruh Sub Layanan';
    $data['link'] = base_url('API/Subservices/generateDatatable');
    $this->render('subservice/list_all', $data);
  }
}
