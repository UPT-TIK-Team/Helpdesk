<?php

class Symptom_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('symptom');
  }

  public function generateDatatable($select = null, $where = array(), $join = array(), $column = array(), $as = null, $addcolumn = array())
  {
    return parent::generateDatatable($select, $where, $join, $column, $as, $addcolumn);
  }
}
