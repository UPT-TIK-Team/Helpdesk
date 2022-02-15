<?php

class Messages_model extends BaseMySQL_model
{
  function __construct()
  {
    parent::__construct(TABLE_MESSAGES);
  }

  public function getBy($select = null, $where = null, $limit = null, $array = true)
  {
    return parent::getBy($select, $where, $limit, $array);
  }
}
