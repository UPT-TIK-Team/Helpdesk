<?php
class Condition_model_test extends UnitTestCase
{
  public function setUp(): void
  {
    $this->obj = $this->newModel('expertsystem/Condition_model');
  }

  public function test_get_condition_by_id()
  {
    $result = $this->obj->get_condition(1);
    $expected = ['id' => '1', 'name' => 'Pasti ya'];
    $this->assertEquals($expected, $result);
  }

  public function test_get_condition()
  {
    $return = [
      0 => (object)['id' => '1', 'name' => 'Pasti ya'],
      1 => (object)['id' => '2', 'name' => 'Hampir pasti ya'],
      2 => (object)['id' => '3', 'name' => 'Kemungkinan besar ya']
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
    $this->verifyInvokedOnce($db, 'get', ['condition']);

    $this->obj->db = $db;

    $expected = [
      1 => 'Pasti ya',
      2 => 'Hampir pasti ya',
      3 => 'Kemungkinan besar ya'
    ];

    $list = $this->obj->get_condition();
    foreach ($list as $condition) {
      $this->assertEquals($expected[$condition->id], $condition->name);
    }
  }
}
