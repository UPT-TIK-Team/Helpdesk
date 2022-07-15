<?php

class Expertsystem extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    // parent::requireLogin();
    $this->load->model('expertsystem/Problem_model', 'Problem');
    $this->load->model('expertsystem/Symptom_model', 'Symptom');
    $this->load->model('expertsystem/Rules_model', 'Rules');
    $this->load->model('expertsystem/Condition_model', 'Condition');
    // $this->id = $this->Session->getLoggedDetails()['id'];
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
      $data['problem'] = $this->Problem->get_problem_by_id($id);
      $data['problem']['solution'] = implode(';', unserialize($data['problem']['solution']));
      $this->render('expertsystem/problem_view', $data);
    } else {
      $data = [
        'name' => $this->input->post('name', true),
        'solution' => serialize(explode(';', $this->input->post('solution', true)))
      ];
      $this->Problem->update_problem($id, $data);
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
    if ($id === null) redirect(base_url('expertsystem/all_problems'));
    // Check if problem relate to another rule
    $relateRules = $this->db->where('id_problem', $id)->get('rule')->num_rows();
    if ($relateRules > 0) {
      $this->session->set_flashdata('failed', 'Data masalah ini masih memiliki aturan yang terkait, silahkan hapus aturan tersebut terlebih dahulu!');
      redirect(base_url('expertsystem/all_problems'));
    } else {
      $this->Problem->delete_by_id($id);
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
      $data['symptom'] = $this->Symptom->get_symptom_by_id($id);
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
    $this->Symptom->delete_by_id($id);
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
      $data['title'] = 'Aturan';
      $data['rule'] = $this->Rules->get_rule_by_id($id);
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
    $this->Rules->delete_by_id($id);
    if ($this->db->affected_rows()) {
      $this->session->set_flashdata('success', 'Data aturan berhasil dihapus');
      redirect(base_url('expertsystem/all_rules'));
    }
  }
}
