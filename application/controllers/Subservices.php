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

  public function delete($id)
  {
    $this->db->delete('subservices', ['id' => $id]);
    if ($this->db->affected_rows()) redirect(base_url('subservices/list_all'));
  }
}
