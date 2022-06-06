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
    $data['link'] = base_url('API/Services_API/generateDatatable');
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
      redirect(base_url('services/list_all'));
    }
  }

  public function edit($id)
  {
    if (!$this->input->post()) {
      $data['title'] = 'Layanan';
      $data['service'] = $this->db->where('id', $id)->get('services')->row_array();
      $this->render('service/service_view', $data);
    } else {
      $data = [
        'name' => $this->input->post('name', true),
      ];
      $this->db->update('services', $data, ['id' => $id]);
      if ($this->db->affected_rows()) {
        $this->session->set_flashdata('success', 'Layanan berhasil di ubah');
        redirect(base_url('services/list_all'));
      } else {
        $this->session->set_flashdata('failed', 'Layanan tidak ada perubahan');
        redirect(base_url('services/list_all'));
      }
    }
  }
}
