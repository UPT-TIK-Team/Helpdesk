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
    $this->load->model('expertsystem/Problem_model', 'Problem');
    $this->load->model('expertsystem/Symptom_model', 'Symptom');
    $this->load->model('expertsystem/Rules_model', 'Rules');
    $this->load->model('expertsystem/Condition_model', 'Condition');
    $this->load->model('user/User_model', 'Users');
  }

  /**
   * Function for handle diagnose problem
   */
  public function diagnose()
  {
    // Get subservice id 
    $id_subservice = $this->input->post('id_subservice');
    // Get symptom by subservice id
    $data['symptom'] = $this->Symptom->get_symptom($id_subservice);
    $data['condition'] = $this->Condition->get_condition();
    $this->load->view('expertsystem/list_diagnose', $data);
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
        $select = 'symptom.code, symptom.name, subservices.name';
        $join = ['subservices'];
        $columnJoin = ['id_subservice'];
        $as = 'symptom.code as code, symptom.name as symptom, subservices.name as subservice';
        echo $this->Symptom->generateDatatable($select, null, $join, $columnJoin, $as);
        break;
      case 'problems':
        $select = "code, name";
        echo $this->Problem->generateDatatable($select);
        break;
      case 'rules':
        $select = 'problem.name, symptom.name, mb, md';
        $join = ['problem', 'symptom'];
        $columnJoin = ['id_problem', 'id_symptom'];
        $as = 'problem.name as problem, symptom.name as symptom';
        echo $this->Rules->generateDatatable($select, null, $join, $columnJoin, $as);
        break;
    }
  }

  /**
   * Function to handle add problem endpoint
   */
  public function addproblem()
  {
    $problemName = htmlspecialchars($this->input->post('problem-name', true));
    $solution = htmlspecialchars($this->input->post('solution', true));
    $idSubservice = htmlspecialchars($this->input->post('subservice', true));
    // Get last id in problem table
    $lastID = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('problem')->row_array()['id'];
    // Generate code problem
    $code = 'P' . str_pad((int)$lastID + 1, 2, '0', STR_PAD_LEFT);
    $data = [
      'code' => $code,
      'name' => $problemName,
      'solution' => $solution,
      'id_subservice' => $idSubservice
    ];
    $this->db->insert('problem', $data);
    redirect('expertsystem/all_problems');
  }

  /**
   * Function to handle add symptom endpoint
   */
  public function addsymptom()
  {
    $symptomName = htmlspecialchars($this->input->post('symptom-name', true));
    $id_subservice =  htmlspecialchars($this->input->post('subservice', true));
    // Get last id in symptom table
    $lastID = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('symptom')->row_array()['id'];
    // Generate code problem
    $code = 'G' . str_pad((int)$lastID + 1, 2, '0', STR_PAD_LEFT);
    $data = [
      'code' => $code,
      'name' => $symptomName,
      'id_subservice' => $id_subservice
    ];
    $this->db->insert('symptom', $data);
    redirect('expertsystem/all_symptoms');
  }

  /**
   * Function to handle add rules endpoint
   */
  public function addrules()
  {
    $id_problem = htmlspecialchars($this->input->post('problem', true));
    $id_symptom = htmlspecialchars($this->input->post('symptom', true));
    $mb =  htmlspecialchars($this->input->post('mb', true));
    $md =  htmlspecialchars($this->input->post('md', true));
    $data = [
      'id_problem' => $id_problem,
      'id_symptom' => $id_symptom,
      'mb' => floatval($mb),
      'md' => floatval($md),
    ];
    $this->db->insert('rule', $data);
    redirect('expertsystem/all_rules');
  }

  /**
   * Function for handle get all problem
   */
  public function getproblem($id_subservice = null)
  {
    $this->sendJSON($this->Problem->get_problem($id_subservice));
  }

  /**
   * Function for handle get all symptom
   */
  public function getsymptom($id_subservice = null)
  {
    $this->sendJSON($this->Symptom->get_symptom($id_subservice));
  }
}
