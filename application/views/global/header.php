<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= PRODUCT_NAME ?> | <?= $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Load necessary javascript files -->
  <script src="<?= base_url('assets/js/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/chart.js/Chart.min.js') ?>"></script>
  <!-- Style for loader class -->
  <style>
    .loader {
      position: fixed;
      width: 100%;
      height: 100%;
      padding-top: 18%;
      z-index: 9999;
      display: block;
      background-color: white;
      opacity: 5;
      text-align: center;
    }

    .loader img {
      width: 120px;
    }
  </style>
  <link rel="stylesheet" href="<?= base_url('assets/js/plugins/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/js/plugins/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/fontastic.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.default.css') ?>" id="theme-stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
  <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/js/plugins/toastr/toastr.min.css') ?>">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link href="<?= base_url('assets/js/plugins/select2/select2.min.css') ?>" rel="stylesheet" />

</head>

<body>
  <div class="loader"></div>
  <div class="page">
    <!-- Main Navbar-->
    <header class="header">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-holder d-flex align-items-center justify-content-between">
            <!-- Navbar Header-->
            <div class="navbar-header">
              <!-- Navbar Brand --><a href="<?= base_url('user/dashboard') ?>" class="navbar-brand d-none d-sm-inline-block">
                <div class="brand-text d-none d-lg-inline-block"><?= PRODUCT_NAME ?></div>
                <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong><?= PRODUCT_NAME ?></strong></div>
              </a>
              <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
            </div>
            <!-- Navbar Menu -->
            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
              <li class="dotted-add-button"><a href="<?= base_url('tickets/create_new') ?>"><i class="fa fa-plus-square"></i> New ticket</a></li>
              <li class="nav-item dropdown">
                <a class="nav-link sidebar-header d-flex align-items-center" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="current-user-avatar" data-username="<?= $this->Session->getLoggedDetails()['username'] ?>"></div>
                  <div class="title pl-2">
                    <?= $this->Session->getLoggedDetails()['username'] !== '' ? $this->Session->getLoggedDetails()['username'] : $this->Session->getLoggedDetails()['email']; ?>
                  </div>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="<?= base_url('user/profile') ?>"><i class="fa fa-user bg-info"></i> Profile</a>
                  <a class="dropdown-item" href="<?= base_url('user/change_password') ?>"><i class=" fa fa-lock bg-orange"></i> Change password</a>
                  <div class="dropdown-divider"></div>
                  <!-- Logout -->
                  <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fa fa-sign-out bg-red"></i>Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>

      </nav>
    </header>
    <div class="page-content d-flex align-items-stretch">
      <!-- Side Navbar -->
      <nav class="side-navbar">
        <!-- Sidebar Navidation Menus-->
        <ul class="list-unstyled">
          <!-- TODO: Change below session data fetching !-->
          <?php include_once "menus/" . $this->session->userdata('sessions_details')['type'] . ".php"; ?>
        </ul>
      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom"><?= $title ?></h2>
          </div>
        </header>