<?php

class Expertsystem extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
    $this->load->model('expertsystem/Problem_model', 'Problem');
    $this->load->model('expertsystem/Symptom_model', 'Symptom');
    $this->load->model('expertsystem/Rules_model', 'Rules');
    $this->load->model('expertsystem/Condition_model', 'Condition');
    $this->id = $this->Session->getLoggedDetails()['id'];
  }

  public function diagnose()
  {
    $data['title'] = 'Diagnosa Masalah';
    $this->render('expertsystem/diagnose', $data);
  }

  public function all_problems()
  {
    $data['title'] = 'Daftar Seluruh Masalah';
    $this->render('expertsystem/all_problems', $data);
  }

  public function all_symptoms()
  {
    $data['title'] = 'Daftar Seluruh Gejala';
    $this->render('expertsystem/all_symptoms', $data);
  }

  public function all_rules()
  {
    $data['title'] = 'Daftar Seluruh Aturan';
    $this->render('expertsystem/all_rules', $data);
  }

  /**
   * Function for calculate certainty factor result
   */
  public function result()
  {
    $id_subservice = htmlspecialchars($this->input->post('id_subservice', true));
    // Condition value that provide in condition dropdown
    $condition_value_array = ['0', '1', '0.8', '0.6', '0.4', '-0.2', '-0.4', '-0.6', '-0.8', '-1'];
    $symptom_array = array();
    // Fill symptom array based on user answers
    for ($i = 0; $i < count($_POST['condition']); $i++) {
      $symptom_condition_array = explode('_', $_POST['condition'][$i]);
      if (strlen($_POST['condition'][$i]) > 1) {
        $symptom_array += [$symptom_condition_array[0] => $symptom_condition_array[1]];
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
        // Fill problem array if last cf is bigger than 0
        $problem_array += array($rule['id_problem'] => number_format($last_cf, 4));
      }
    }
    // Sort array descending by value
    arsort($problem_array);
    $result = [
      'id_user' => $this->session->userdata('sessions_details')['id'],
      'id_problem' => array_key_first($problem_array),
      'problem' => serialize($problem_array),
      'symptom' => serialize($symptom_array),
      'result' => reset($problem_array)
    ];
    $this->db->insert('analyst_result', $result);
    $data['problem'] = $this->db->where('id', $result['id_problem'])->get('problem')->row_array();
    $this->load->view('expertsystem/diagnose_result', $data);
  }
}
