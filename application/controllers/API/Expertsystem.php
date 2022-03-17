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

  public function generatedatatable()
  {
    $select = "code, name, solution";
    echo $this->Problem->generateDatatable($select);
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
}
