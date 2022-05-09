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

  public function edit_problem($id)
  {
    if (!$this->input->post()) {
      $data['title'] = 'Masalah';
      $data['problem'] = $this->db->where('id', $id)->get('problem')->row_array();
      $data['problem']['solution'] = implode(';', unserialize($data['problem']['solution']));
      $this->render('expertsystem/problem_view', $data);
    } else {
      $data = [
        'name' => $this->input->post('name', true),
        'solution' => serialize(explode(';', $this->input->post('solution', true)))
      ];
      $this->db->update('problem', $data, ['id' => $id]);
      if ($this->db->affected_rows()) {
        $this->session->set_flashdata('success', 'Data masalah berhasil di ubah');
        redirect(base_url('expertsystem/all_problems'));
      } else {
        $this->session->set_flashdata('failed', 'Data masalah tidak ada perubahan');
        redirect(base_url('expertsystem/all_problems'));
      }
    }
  }

  public function delete_problem($id)
  {
    $totalRule = $this->db->where('id_problem', $id)->get('rule')->num_rows();
    if ($totalRule > 0) {
      $this->session->set_flashdata('failed', 'Data masalah ini masih memiliki aturan yang terkait, silahkan hapus aturan tersebut terlebih dahulu!');
      redirect(base_url('expertsystem/all_problems'));
    } else {
      $this->db->delete('problem', ['id' => $id]);
      redirect(base_url('expertsystem/all_problems'));
    }
  }

  public function all_symptoms()
  {
    $data['title'] = 'Daftar Seluruh Gejala';
    $this->render('expertsystem/all_symptoms', $data);
  }

  public function edit_symptom($id)
  {
    if (!$this->input->post()) {
      $data['title'] = 'Gejala';
      $data['symptom'] = $this->db->select('symptom.name as name_symptom, subservices.id as id_subservice, subservices.name as name_subservice')->where('symptom.id', $id)->join('subservices', 'symptom.id_subservice=subservices.id')->get('symptom')->row_array();
      $this->render('expertsystem/symptom_view', $data);
    } else {
      $data = [
        'name' => $this->input->post('name', true),
        'id_subservice' => $this->input->post('subservice', true),
      ];
      $this->db->update('symptom', $data, ['id' => $id]);
      if ($this->db->affected_rows()) {
        $this->session->set_flashdata('success', 'Data gejala berhasil di ubah');
        redirect(base_url('expertsystem/all_symptoms'));
      } else {
        $this->session->set_flashdata('failed', 'Data gejala tidak ada perubahan');
        redirect(base_url('expertsystem/all_symptoms'));
      }
    }
  }

  public function delete_symptom($id)
  {
    $this->db->delete('symptom', ['id' => $id]);
    if ($this->db->affected_rows()) {
      $this->session->set_flashdata('success', 'Data gejala berhasil dihapus');
      redirect(base_url('expertsystem/all_symptoms'));
    }
  }

  public function all_rules()
  {
    $data['title'] = 'Daftar Seluruh Aturan';
    $this->render('expertsystem/all_rules', $data);
  }

  public function edit_rule($id)
  {
    if (!$this->input->post()) {
      $data['title'] = 'Gejala';
      $data['rule'] = $this->db->select('problem.id as id_problem, problem.name as name_problem, symptom.id as id_symptom, symptom.name as name_symptom, mb, md')->where('rule.id', $id)->join('problem', 'rule.id_problem=problem.id')->join('symptom', 'rule.id_symptom=symptom.id')->get('rule')->row_array();
      $this->render('expertsystem/rule_view', $data);
    } else {
      $data = [
        'id_problem' => $this->input->post('problem', true),
        'id_symptom' => $this->input->post('symptom', true),
        'mb' => $this->input->post('mb', true),
        'md' => $this->input->post('md', true),
      ];
      $this->db->update('rule', $data, ['id' => $id]);
      if ($this->db->affected_rows()) {
        $this->session->set_flashdata('success', 'Data aturan berhasil di ubah');
        redirect(base_url('expertsystem/all_rules'));
      } else {
        $this->session->set_flashdata('failed', 'Data aturan tidak ada perubahan');
        redirect(base_url('expertsystem/all_rules'));
      }
    }
  }

  public function delete_rule($id)
  {
    $this->db->delete('rule', ['id' => $id]);
    if ($this->db->affected_rows()) {
      $this->session->set_flashdata('success', 'Data aturan berhasil dihapus');
      redirect(base_url('expertsystem/all_rules'));
    }
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
    $this->load->view('expertsystem/diagnose_result', $data);
  }
}
