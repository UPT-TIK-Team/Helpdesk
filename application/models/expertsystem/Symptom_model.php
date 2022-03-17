<?php

class Symptom_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('symptom');
    $this->load->model("core/Session_model", "Session");
  }
}
