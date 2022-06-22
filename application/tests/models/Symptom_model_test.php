<?php
class Symptom_model_test extends UnitTestCase
{
  public function setUp(): void
  {
    $this->obj = $this->newModel('expertsystem/Symptom_model');
  }

  public function test_get_symptom()
  {
    $return = [
      0 => (object)['id' => '1', 'code' => 'P01', 'name' => 'Nilai tidak muncul di krs'],
    ];
    $db_result = $this->getMockBuilder('CI_DB_mysqli_result')
      ->disableOriginalConstructor()
      ->getMock();
    $db_result->method('result_array')->willReturn($return);
    $db = $this->getMockBuilder('CI_DB_mysqli_driver')
      ->disableOriginalConstructor()
      ->getMock();
    $db->method('get')->willReturn($db_result);

    $this->verifyInvokedOnce($db_result, 'result_array', []);
    $this->verifyInvokedOnce($db, 'get', ['symptom']);

    $this->obj->db = $db;

    $expected = [
      1 => 'Nilai tidak muncul di krs'
    ];

    $list = $this->obj->get_symptom();
    foreach ($list as $symptom) {
      $this->assertEquals($expected[$symptom->id], $symptom->name);
    }
  }

  public function test_add_symptom()
  {
    $result = [
      0 => (object)['id' => '1', 'code' => 'P01', 'name' => 'Nilai tidak muncul di krs'],
    ];
    $db = $this->getMockBuilder('CI_DB_mysqli_driver')
      ->disableOriginalConstructor()
      ->getMock();
    $db->method('insert')->willReturn($result);

    $this->obj->db = $db;

    $expected = [
      0 => (object)['id' => '1', 'code' => 'P01', 'name' => 'Nilai tidak muncul di krs'],
    ];

    $output = $this->obj->add_symptom([0 => (object)['id' => '1', 'code' => 'P01', 'name' => 'Nilai tidak muncul di krs']]);
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
