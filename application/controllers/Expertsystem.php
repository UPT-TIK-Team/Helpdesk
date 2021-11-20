<?php

class Expertsystem extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
    $this->load->model('expertsystem/Gejala_model', 'Gejala');
    $this->id = $this->Session->getLoggedDetails()['id'];
  }

  public function diagnose()
  {
    $this->db->query('delete from tmp_gejala where id_user=?', [$this->id]);
    $this->db->query('delete from tmp_analisa where id_user=?', [$this->id]);
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
    $kondisi = $this->input->post('kondisi', true);
    foreach ($kondisi as $i => $val) {
      $data = [
        'id_gejala' => $i + 1,
        'status' => $val,
        'id_user' => $this->id
      ];
      $this->db->insert('tmp_gejala', $data);
    }
    $hasilAnalisa = $this->db->query("SELECT id_problem, count(rule.id_gejala) AS total, SUM(status='yes') AS sesuai FROM rule LEFT JOIN tmp_gejala ON rule.id_gejala = tmp_gejala.id_gejala WHERE id_user=? GROUP BY id_problem", [$this->id])->result_array();
    foreach ($hasilAnalisa as $row) {
      $persentase = $row['sesuai'] / $row['total'] * 100;
      $data = [
        'id_problem' => $row['id_problem'],
        'persentase' => $persentase,
        'id_user' => $this->id
      ];
      $this->db->insert('tmp_analisa', $data);
    }
    $hasil = $this->db->query('SELECT id_problem FROM tmp_analisa WHERE persentase = (SELECT MAX(persentase) FROM tmp_analisa WHERE id_user=?) AND id_user=?', [$this->id, $this->id])->row_array();
    $data = [
      'id_problem' => $hasil['id_problem'],
      'id_user' => $this->id
    ];
    $this->db->insert('hasil_analisa', $data);
    $maxIdAnalisa = $this->db->select_max('id')->get('hasil_analisa')->row_array()['id'];
    $data['problem'] = $this->db->select('code, name')->join('problem', 'analisa.id_problem=problem.id')->where('analisa.id', $maxIdAnalisa)->where('id_user', $this->id)->get('hasil_analisa as analisa')->row_array();
    $this->load->view('expertsystem/hasildiagnosa', $data);
    $this->db->query('delete from tmp_gejala where id_user=?', [$this->id]);
    $this->db->query('delete from tmp_analisa where id_user=?', [$this->id]);
  }
}
