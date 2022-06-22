<?php
class Problem_model_test extends UnitTestCase
{
  public function setUp(): void
  {
    $this->obj = $this->newModel('expertsystem/Problem_model');
  }

  public function test_get_problem()
  {
    $return = [
      0 => (object)['id' => '1', 'code' => 'P01', 'name' => 'Nilai tidak ada'],
      1 => (object)['id' => '2', 'code' => 'P02', 'name' => 'Nilai berbeda dengan sistem SIAKAD/SIMAK'],
      2 => (object)['id' => '3', 'code' => 'P03', 'name' => 'Matakuliah tidak ditemukan'],
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
    $this->verifyInvokedOnce($db, 'get', ['problem']);

    $this->obj->db = $db;

    $expected = [
      1 => 'Nilai tidak ada',
      2 => 'Nilai berbeda dengan sistem SIAKAD/SIMAK',
      3 => 'Matakuliah tidak ditemukan'
    ];

    $list = $this->obj->get_problem();
    foreach ($list as $problem) {
      $this->assertEquals($expected[$problem->id], $problem->name);
    }
  }

  public function test_add_problem()
  {
    $result = [0 => (object)['id' => '3', 'code' => 'P03', 'name' => 'Matakuliah tidak ditemukan']];
    $db = $this->getMockBuilder('CI_DB_mysqli_driver')
      ->disableOriginalConstructor()
      ->getMock();
    $db->method('insert')->willReturn($result);

    $this->obj->db = $db;

    $expected = [
      0 => (object)['id' => '3', 'code' => 'P03', 'name' => 'Matakuliah tidak ditemukan']
    ];

    $output = $this->obj->add_problem([
      0 => (object)['id' => '3', 'code' => 'P03', 'name' => 'Matakuliah tidak ditemukan']
    ]);
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

  public function test_update_problem()
  {
    $data = [
      'name' => 'nilai tidak ada',
      'solution' => 'centang hitung ulang'
    ];
    $db = $this->getMockBuilder('CI_DB_mysqli_driver')
      ->disableOriginalConstructor()
      ->getMock();
    $db->method('update')->willReturn(true);

    $this->obj->db = $db;

    $expected = true;

    $output = $this->obj->update_problem(1, $data);
    $this->assertEquals($expected, $output);
  }
}
