<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Google extends Google_Client
{
  public function __construct()
  {
    parent::__construct();
    $this->setClientId('867117223285-ns5b19k3tsotcf7pothrl1i2qqhvblv4.apps.googleusercontent.com');
    $this->setClientSecret('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');
    $this->setRedirectUri('http://localhost/Helpdesk/tickets/create_new');
    $this->addScope('https://www.googleapis.com/auth/drive');
    $this->setAccessType('offline');
  }
}
