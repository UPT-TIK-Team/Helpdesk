<?php

class Expertsystem extends MY_Controller
{
  function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
    parent::requireLogin();
    $this->load->model('core/Session_model', 'Session');
    $this->load->model('expertsystem/Symptom_model', 'Symptom');
    $this->load->model('expertsystem/Problem_model', 'Problem');
    $this->load->model('user/User_model', 'Users');
  }

  /** 
   * Function to get data and create datatable serverside
   */
  public function generatedatatable()
  {
    $endpoint = $this->input->post('endpoint', true);
    // Switch endpoint and send appropriate data
    switch ($endpoint) {
      case 'symptoms':
        $select = 'code, symptom.name, services.name';
        $join = ['services'];
        $columnJoin = ['id_service'];
        $as = 'symptom.name as symptom, services.name as service';
        echo $this->Symptom->generateDatatable($select, null, $join, $columnJoin, $as);
        break;
      case 'problems':
        $select = "code, name, solution";
        echo $this->Problem->generateDatatable($select);
        break;
    }
  }

  /**
   * Function for handle add new problem
   */
  public function addproblem()
  {
    $problemName = htmlspecialchars($this->input->post('problem-name', true));
    $solution = htmlspecialchars($this->input->post('solution', true));
    // Get last id in problem table
    $lastID = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('problem')->row_array()['id'];
    // Generate code problem
    $code = 'P' . str_pad((int)$lastID + 1, 2, '0', STR_PAD_LEFT);
    $data = [
      'code' => $code,
      'name' => $problemName,
      'solution' => $solution
    ];
    $this->db->insert('problem', $data);
    redirect('expertsystem/all_problems');
  }

  public function addsymptom()
  {
    $symptomName = htmlspecialchars($this->input->post('symptom-name', true));
    $idService =  htmlspecialchars($this->input->post('service', true));
    // Get last id in symptom table
    $lastID = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('symptom')->row_array()['id'];
    // Generate code problem
    $code = 'G' . str_pad((int)$lastID + 1, 2, '0', STR_PAD_LEFT);
    $data = [
      'code' => $code,
      'name' => $symptomName,
      'id_service' => $idService
    ];
    $this->db->insert('symptom', $data);
    redirect('expertsystem/all_symptoms');
  }
}
