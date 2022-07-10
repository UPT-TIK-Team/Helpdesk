<?php if ($this->session->flashdata('info')) : ?>
  <li><a href="<?= BASE_URL ?>expertsystem/diagnose"> <i class="fa fa-globe"></i>Sistem Pakar <span class="badge badge-warning">Beta</span></a></li>
<?php else : ?>
  <li><a href="<?= BASE_URL ?>user/dashboard"> <i class="fa fa-home"></i>Dashboard </a></li>
  <li><a href="#ticketsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list"></i>Tiket</a>
    <ul id="ticketsDropdown" class="collapse list-unstyled ">
      <li><a href="<?= BASE_URL ?>tickets/create_new"> <i class="fa fa-ticket"></i>Buat Tiket</a></li>
      <li><a href="<?= BASE_URL ?>tickets/my_tickets"> <i class="fa fa-list"></i>Tiket Saya</a></li>
    </ul>
  </li>
  <li><a href="<?= BASE_URL ?>expertsystem/diagnose"> <i class="fa fa-globe"></i>Sistem Pakar <span class="badge badge-warning">Beta</span></a></li>
  <li><a href="<?= base_url('user/userGuide') ?>"><i class="fa fa-book"></i>Petunjuk Pengguna</a></li>
  <li><a href="<?= BASE_URL ?>user/profile"> <i class="fa fa-user"></i>Profil</a></li>
<?php endif; ?>