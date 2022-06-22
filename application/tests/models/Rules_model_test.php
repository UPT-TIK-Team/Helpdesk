<?php
class Rules_model_test extends UnitTestCase
{
  public function setUp(): void
  {
    $this->obj = $this->newModel('expertsystem/Rules_model');
  }

  public function test_add_rule()
  {
    $result = [
      0 => (object)['id_problem' => '9', 'name_problem' => 'Jaringan terbatas atau tidak ada konektivitas', 'id_symptom' => '19', 'name_symptom' => 'Kabel terpasang dengan baik', 'mb' => '0.6', 'md' => '0.2'],
    ];
    $db = $this->getMockBuilder('CI_DB_mysqli_driver')
      ->disableOriginalConstructor()
      ->getMock();
    $db->method('insert')->willReturn($result);

    $this->obj->db = $db;

    $expected = [
      0 => (object)['id_problem' => '9', 'name_problem' => 'Jaringan terbatas atau tidak ada konektivitas', 'id_symptom' => '19', 'name_symptom' => 'Kabel terpasang dengan baik', 'mb' => '0.6', 'md' => '0.2'],
    ];

    $output = $this->obj->add_rule([0 => (object)['id_problem' => '9', 'name_problem' => 'Jaringan terbatas atau tidak ada konektivitas', 'id_symptom' => '19', 'name_symptom' => 'Kabel terpasang dengan baik', 'mb' => '0.6', 'md' => '0.2']]);
    $this->assertEquals($expected, $output);
  }

  public function test_delete_by_id()
  {
    $db = $this->getMockBuilder('CI_DB_mysqli_driver')
      ->disableOriginalConstructor()
      ->getMock();
    $db->method('delete')->willReturn(true);

    $this->obj->db = $db;

    $expected = true;

    $output = $this->obj->delete_by_id(1);
    $this->assertEquals($expected, $output);
  }
}
