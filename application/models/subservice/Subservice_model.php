<?php

class Subservice_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('subservices');
    $this->load->model("core/Session_model", "Session");
  }

  public function generateDatatable($select = null, $where = null, $join = array(), $column = array(), $as = null)
  {
    return parent::generateDatatable($select, $where, $join, $column, $as);
  }
}
