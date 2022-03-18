<?php

class Expertsystem extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
    $this->load->model('expertsystem/Symptom_model', 'Symptom');
    $this->id = $this->Session->getLoggedDetails()['id'];
  }

  public function diagnose()
  {
    $this->db->query('delete from tmp_symptom where id_user=?', [$this->id]);
    $this->db->query('delete from tmp_analyst where id_user=?', [$this->id]);
    if ($this->input->post('idservice')) {
      // Fill parameter value
      $idservice = $this->input->post('idservice');
      $select = 'symptom.id, symptom.code, symptom.name';
      $join = ['services'];
      $columnjoin = ['id_service'];
      $as = null;
      $array = true;

      // Execute diagnose query
      $data['symptom'] = $this->Symptom->getTableJoin($select, ['id_service' => $idservice], $join, $columnjoin, $as, $array);
      $this->load->view('expertsystem/list_diagnose', $data);
    } else {
      $data['title'] = 'Diagnose Problem';
      $this->render('expertsystem/diagnose', $data);
    }
  }

  public function all_problems()
  {
    $data['title'] = 'List All Problems';
    $this->render('expertsystem/all_problems', $data);
  }

  public function all_symptoms()
  {
    $data['title'] = 'List All Symptoms';
    $this->render('expertsystem/all_symptoms', $data);
  }

  public function all_rules()
  {
  }

  public function hasilDiagnosa()
  {
    $kondisi = $this->input->post('kondisi', true);
    foreach ($kondisi as $i => $val) {
      $data = [
        'id_symptom' => $i + 1,
        'status' => $val,
        'id_user' => $this->id
      ];
      $this->db->insert('tmp_symptom', $data);
    }
    $analystResult = $this->db->query("SELECT id_problem, count(rule.id_symptom) AS total, SUM(status='yes') AS sesuai FROM rule LEFT JOIN tmp_symptom ON rule.id_symptom = tmp_symptom.id_symptom WHERE id_user=? GROUP BY id_problem", [$this->id])->result_array();
    foreach ($analystResult as $row) {
      $persentase = $row['sesuai'] / $row['total'] * 100;
      $data = [
        'id_problem' => $row['id_problem'],
        'persentase' => $persentase,
        'id_user' => $this->id
      ];
      $this->db->insert('tmp_analyst', $data);
    }
    $hasil = $this->db->query('SELECT id_problem FROM tmp_analyst WHERE persentase = (SELECT MAX(persentase) FROM tmp_analyst WHERE id_user=?) AND id_user=?', [$this->id, $this->id])->row_array();
    $data = [
      'id_problem' => $hasil['id_problem'],
      'id_user' => $this->id
    ];
    $this->db->insert('analyst_result', $data);
    $maxIdanalyst = $this->db->select_max('id')->get('analyst_result')->row_array()['id'];
    $data['problem'] = $this->db->select('code, name, solusi')->join('problem', 'analyst.id_problem=problem.id')->where('analyst.id', $maxIdanalyst)->where('id_user', $this->id)->get('analyst_result as analyst')->row_array();
    $this->load->view('expertsystem/hasildiagnosa', $data);
    $this->db->query('delete from tmp_symptom where id_user=?', [$this->id]);
    $this->db->query('delete from tmp_analyst where id_user=?', [$this->id]);
  }
}
