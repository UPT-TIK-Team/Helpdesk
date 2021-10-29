<?php

class Gejala_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('gejala');
    $this->load->model("core/Session_model", "Session");
  }

  public function truncateTableTmp($id)
  {
    $this->db->delete('tmp_gejala', ['id_user', $id]);
  }
}
