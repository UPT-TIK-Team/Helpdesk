<?php

class Expertsystem_API extends MY_Controller
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
        $select = 'symptom.id as id_symptom, symptom.code, symptom.name, subservices.name';
        $join = ['subservices'];
        $columnJoin = ['id_subservice'];
        $as = 'symptom.code as code, symptom.name as symptom, subservices.name as subservice';
        echo $this->Symptom->generateDatatable($select, null, $join, $columnJoin, $as);
        break;
      case 'problems':
        $select = "id, code, name, solution";
        echo $this->Problem->generateDatatable($select);
        break;
      case 'rules':
        $select = 'rule.id as id_rule, problem.name, symptom.name, mb, md';
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
      // Seriallize and explode solution before adding to database
      'solution' => serialize(explode(';', $solution)),
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

  /**
   * Function for calculate certainty factor result
   */
  public function result()
  {
    $id_subservice = htmlspecialchars($this->input->post('id_subservice', true));
    // Condition value that provide in condition dropdown
    $condition_value_array = ['0', '1', '0.8', '0.6', '0.4', '0.2', '0'];
    $symptom_array = array();
    // Fill symptom array based on user answers
    for ($i = 0; $i < count($_POST['condition']); $i++) {
      $symptom_condition_array = explode('_', $_POST['condition'][$i]);
      if (strlen($_POST['condition'][$i]) > 1) {
        // Get symptom name based on condition_array
        $symptom_name = $this->db->select('name')->where('id', $symptom_condition_array[0])->get('symptom')->row_array()['name'];
        // Get condition name based on condition_array
        $condition_name = $this->db->select('name')->where('id', $symptom_condition_array[1])->get('condition')->row_array()['name'];
        // Store symptom and condition name in array
        $symptom_array += [$symptom_name => $condition_name];
      }
    }
    $problem_array = array();
    // Get problem based on id subservice
    $problem_idsubservice = $this->Problem->get_problem($id_subservice);
    foreach ($problem_idsubservice as $problem) {
      $cf = 0;
      $rule_array = $this->db->where('id_problem', $problem['id'])->get('rule')->result_array();
      $last_cf = 0;
      foreach ($rule_array as $rule) {
        // Loop all condition that user was answered in question
        for ($i = 0; $i < count($_POST['condition']); $i++) {
          // Explode $_POST condition based on index, the index is code of symptom and value is condition id
          $symptom_condition_array = explode('_', $_POST['condition'][$i]);
          $symptom_id = $symptom_condition_array[0];
          // Check if problem symptom equal to user symptom
          if ($rule['id_symptom'] === $symptom_id) {
            // Get condition id from symptom condition index 1
            $condition_id = $symptom_condition_array[1];
            // Calculate cf value from cf expert people multiple with user condition value
            $cf = ($rule['mb'] - $rule['md']) * $condition_value_array[$condition_id];
            // Check last certainty factor value
            if (($cf >= 0) && ($cf * $last_cf >= 0)) {
              $last_cf = $last_cf + ($cf * (1 - $last_cf));
            }
            if ($cf * $last_cf < 0) {
              $last_cf = ($last_cf + $cf) / (1 - min(abs($last_cf), abs($cf)));
            }
            if (($cf < 0) && ($cf * $last_cf >= 0)) {
              $last_cf = $last_cf + ($cf * (1 + $last_cf));
            }
          }
        }
      }
      if ($last_cf > 0) {
        $problem_name = $this->db->select('name')->where('id', $rule['id_problem'])->get('problem')->row_array()['name'];
        // Fill problem array if last cf is bigger than 0
        $problem_array += array($problem_name => number_format($last_cf, 4));
      }
    }
    // Sort array descending by value
    arsort($problem_array);
    // Store result data in array
    $result = [
      'id_user' => $this->session->userdata('sessions_details')['id'],
      'id_problem' => $this->db->select('id')->where('name', array_key_first($problem_array))->get('problem')->row_array()['id'],
      'problem' => serialize($problem_array),
      'symptom' => serialize($symptom_array),
      'result' => reset($problem_array)
    ];
    $this->db->insert('analyst_result', $result);
    // Set related information and send to view pages
    $data['solution'] = unserialize($this->db->select('solution')->where('id', $result['id_problem'])->get('problem')->row_array()['solution']);
    $data['result_problem'] = [$this->db->select('name')->where('id', $result['id_problem'])->get('problem')->row_array()['name'] => $result['result']];
    $data['problem_list'] = $problem_array;
    $data['symptom_list'] = $symptom_array;
    unset($_SESSION['info']);
    $this->load->view('expertsystem/diagnose_result', $data);
  }
}
