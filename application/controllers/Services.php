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
    $data['title'] = 'Daftar Seluruh Layanan';
    $data['link'] = base_url('API/Services/generateDatatable');
    $this->render('service/list_all', $data);
  }

  public function delete($id)
  {
    $totalSubservice = $this->db->where('id_service', $id)->get('subservices')->num_rows();
    if ($totalSubservice > 0) {
      $this->session->set_flashdata('failed', 'Layanan ini masih memiliki sub layanan terkait, silahkan hapus sub layanan tersebut terlebih dahulu!');
      redirect(base_url('services/list_all'));
    } else {
      $this->db->delete('services', ['id' => $id]);
      if ($this->db->affected_rows()) redirect(base_url('services/list_all'));
    }
  }
}
