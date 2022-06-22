<?php
class Expertsystem_controller_test extends TestCase
{
  public function setUp(): void
  {
    $this->request->setCallable(
      function ($CI) {
        $CI->load->model('core/Session_model');
        $CI->load->model('expertsystem/Symptom_model');
        $CI->load->model('expertsystem/Rules_model');
        $custom_session_mock = $this->getDouble(
          'Session_model',
          ['getLoggedDetails' => ['username' => 'udin', 'type' => '80']]
        );
        $problem_mock = $this->getDouble(
          'Problem_model',
          ['delete_by_id' => ['id' => '1', 'id_subservice' => '3', 'code' => 'P01', 'name' => 'Nilai Berbeda dengan sistem SIAKAD/SIMAK', 'solution' => 'pastikan centang hitung ulang IP/IPK']]
        );
        $symptom_mock = $this->getDouble(
          'Symptom_model',
          ['get_symptom_by_id' => ['name_symptom' => 'Muncul notifikasi harus melakukan pembayaran, namun sudah membayar UKT', 'id_subservice' => '3', 'name_subservice' => 'eCampus-Akademik'], 'delete_by_id' => ['name_symptom' => 'Muncul notifikasi harus melakukan pembayaran, namun sudah membayar UKT', 'id_subservice' => '3', 'name_subservice' => 'eCampus-Akademik']]
        );
        $rules_mock = $this->getDouble(
          'Rules_model',
          ['get_rule_by_id' => ['id_problem' => '9', 'name_problem' => 'Jaringan terbatas atau tidak ada konektivitas', 'id_symptom' => '19', 'name_symptom' => 'Kabel terpasang dengan baik', 'mb' => '0.6', 'md' => '0.2'], 'delete_by_id' => ['id_problem' => '9', 'name_problem' => 'Jaringan terbatas atau tidak ada konektivitas', 'id_symptom' => '19', 'name_symptom' => 'Kabel terpasang dengan baik', 'mb' => '0.6', 'md' => '0.2']]
        );
        $CI->Session = $custom_session_mock;
        $CI->Problem = $problem_mock;
        $CI->Symptom = $symptom_mock;
        $CI->Rules = $rules_mock;
      }
    );
  }

  public function test_diagnose()
  {
    $output = $this->request('GET', 'expertsystem/diagnose');
    $this->assertStringContainsString('<title>UPT TIK HELPDESK | Diagnosa Masalah</title>', $output);
  }

  public function test_all_problems()
  {
    $output = $this->request('GET', 'expertsystem/all_problems');
    $this->assertStringContainsString('<title>UPT TIK HELPDESK | Daftar Seluruh Masalah</title>', $output);
  }

  public function test_edit_problem()
  {
    $output = $this->request('GET', ['expertsystem', 'edit_problem', '1']);
    $this->assertStringContainsString('<title>UPT TIK HELPDESK | Masalah</title>', $output);
    $this->request('POST', ['expertsystem', 'edit_problem', '1'], ['name' => 'udin', 'solution' => 'test']);
  }

  public function test_delete_problem()
  {
    $output = $this->request('GET', ['expertsystem', 'delete_problem', '1']);
    $this->assertEquals('', $output);
    $this->assertResponseCode(302);
  }

  public function test_all_symptoms()
  {
    $output = $this->request('GET', 'expertsystem/all_symptoms');
    $this->assertStringContainsString('<title>UPT TIK HELPDESK | Daftar Seluruh Gejala</title>', $output);
  }

  public function test_edit_symptom()
  {
    $output = $this->request('GET', ['expertsystem', 'edit_symptom', '1']);
    $this->assertStringContainsString('<title>UPT TIK HELPDESK | Gejala</title>', $output);
    $this->request('POST', ['expertsystem', 'edit_symptom', '1'], ['name' => 'udin', 'id_subservice' => '1']);
  }

  public function test_delete_symptom()
  {
    $output = $this->request('GET', ['expertsystem', 'delete_symptom', '1']);
    $this->assertEquals('', $output);
    $this->assertResponseCode(200);
  }

  public function test_all_rules()
  {
    $output = $this->request('GET', 'expertsystem/all_rules');
    $this->assertStringContainsString('<title>UPT TIK HELPDESK | Daftar Seluruh Aturan</title>', $output);
  }

  public function test_edit_rule()
  {
    $output = $this->request('GET', ['expertsystem', 'edit_rule', '1']);
    $this->assertStringContainsString('<title>UPT TIK HELPDESK | Aturan</title>', $output);
    $this->request('POST', ['expertsystem', 'edit_rule', '1'], ['id_problem' => '1', 'id_syptom' => '1', 'mb' => '0.2', 'md' => '0.6']);
  }

  public function test_delete_rule()
  {
    $output = $this->request('GET', ['expertsystem', 'delete_rule', '1']);
    $this->assertEquals('', $output);
    $this->assertResponseCode(200);
  }
}
