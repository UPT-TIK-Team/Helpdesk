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

  public function edit($id)
  {
    if (!$this->input->post()) {
      $data['title'] = 'Sub Layanan';
      $data['subservice'] = $this->db->select('subservices.id, code, subservices.name as name_subservice, services.id as id_service, services.name as name_service, priority.id as id_priority, priority.name as name_priority')->where('subservices.id', $id)->join('services', 'subservices.id_service=services.id')->join('priority', 'subservices.id_priority=priority.id')->get('subservices')->row_array();
      $this->render('subservice/subservice_view', $data);
    } else {
      $data = [
        'code' => $this->input->post('code', true),
        'id_service' => $this->input->post('service', true),
        'name' => $this->input->post('subservice', true),
        'id_priority' => $this->input->post('priority', true),
      ];
      $this->db->update('subservices', $data, ['id' => $id]);
      if ($this->db->affected_rows()) redirect(base_url('subservices/list_all'));
    }
  }
}
