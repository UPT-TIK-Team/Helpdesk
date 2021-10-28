<?php

class Expertsystem extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
    $this->load->model('expertsystem/Gejala_model', 'Gejala');
  }

  public function diagnose()
  {
    if ($this->input->post('idservice')) {
      $idservice = $this->input->post('idservice');
      $select = 'gejala.id, gejala.code, gejala.name';
      $join = ['services'];
      $columnjoin = ['id_service'];
      $data['gejala'] = $this->Gejala->getTableJoin($select, ['id_service' => $idservice], $join, $columnjoin, null, true);
      $this->load->view('expertsystem/list_diagnose', $data);
    } else {
      $data['title'] = 'Diagnose Problem';
      $this->render('expertsystem/diagnose', $data);
    }
  }

  public function hasilDiagnosa()
  {
    $data['title'] = 'Hasil Diagnosa';
    $kondisi = $this->input->post('kondisi');
    foreach ($kondisi as $i => $val) {
      $data = [
        'id_gejala' => $i + 1,
        'status' => $val
      ];
      $this->db->insert('tmp_gejala', $data);
    }
    $hasilAnalisa = $this->db->query("SELECT id_problem, count(rule.id_gejala) AS total, SUM(status='1') AS sesuai FROM rule LEFT JOIN tmp_gejala ON rule.id_gejala = tmp_gejala.id_gejala GROUP BY id_problem")->result_array();
    foreach ($hasilAnalisa as $row) {
      $persentase = $row['sesuai'] / $row['total'] * 100;
      $this->db->query("INSERT INTO tmp_analisa (id_problem, persentase) VALUES ('$row[id_problem]', '$persentase')");
    }
    $this->render('expertsystem/hasildiagnosa', $data);
  }
}
