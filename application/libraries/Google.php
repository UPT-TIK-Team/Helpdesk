<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Google extends Google_Client
{
  public function __construct()
  {
    parent::__construct();
    $this->setClientId(getenv("GOOGLE_CLIENT_ID"));
    $this->setClientSecret(getenv("GOOGLE_CLIENT_SECRET"));
    $this->addScope('https://www.googleapis.com/auth/drive');
    $this->setAccessType('offline');
    $this->setApprovalPrompt('force');
  }
}
