<li><a href="<?= BASE_URL ?>user/dashboard"> <i class="fa fa-home"></i>Dashboard </a></li>

<li><a href="#ticketsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list"></i>Tiket</a>
  <ul id="ticketsDropdown" class="collapse list-unstyled ">
    <li><a href="<?= BASE_URL ?>tickets/create_new">Buat Tiket</a></li>
    <li><a href="<?= BASE_URL ?>tickets/list_all">Seluruh Tiket</a></li>
    <li><a href="<?= BASE_URL ?>tickets/unassigned_tickets">Tiket Yang Belum Ditugaskan</a></li>
    <li><a href="<?= BASE_URL ?>tickets/assigned_tickets">Tiket Yang Ditugaskan</a></li>
    <li><a href="<?= BASE_URL ?>tickets/closed_tickets">Tiket Selesai</a></li>
    <li><a href="<?= BASE_URL ?>tickets/my_tickets" title="Created by me">Tiket Saya</a></li>
  </ul>
</li>

<li><a href="#usersDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-users"></i>Pengguna</a>
  <ul id="usersDropdown" class="collapse list-unstyled ">
    <li><a href="<?= BASE_URL ?>user/list">Seluruh Pengguna</a></li>
  </ul>
</li>


<li><a href="#masterMenuDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-archive"></i>Master</a>
  <ul id="masterMenuDropdown" class="collapse list-unstyled ">
    <li><a href="<?= base_url('services/list_all') ?>">Seluruh Layanan</a></li>
    <li><a href="<?= base_url('subservices/list_all') ?>">Seluruh Sub Layanan</a></li>
  </ul>
</li>
<li><a href="#guides" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-compass"></i>Petunjuk</a>
  <ul id="guides" class="collapse list-unstyled ">
    <li><a href="https://bit.ly/HelpdeskTIK" target="_blank"><i class="fa fa-book"></i>Petunjuk Pengguna</a></li>
    <li><a href="https://docs.google.com/spreadsheets/d/14wy68XRQXP7WP-rhdqc_9tgJv8Ki4hUO/edit?usp=sharing&ouid=114839779398880711559&rtpof=true&sd=true" target="_blank"><i class="fa fa-list-alt"></i>Katalog Pelayanan TIK</a></li>
  </ul>
</li>
<li><a href="#expert-sytem" aria-expanded="false" data-toggle="collapse"><i class="fa fa-etsy"></i>Sistem Pakar<span class="badge badge-warning">Beta</span></a>
  <ul id="expert-sytem" class="collapse list-unstyled ">
    <li><a href="<?= BASE_URL ?>expertsystem/all_problems"><i class="fa fa-exclamation-circle"></i>Tabel Masalah</a></li>
    <li><a href="<?= BASE_URL ?>expertsystem/all_symptoms"><i class="fa fa-asterisk"></i>Tabel Gejala</a></li>
    <li><a href="<?= BASE_URL ?>expertsystem/all_rules"><i class="fa fa-registered"></i>Tabel Aturan</a></li>
    <li><a href="<?= BASE_URL ?>expertsystem/diagnose"><i class="fa fa-globe"></i>Diagnosa Permasalahan</a></li>
  </ul>
</li>
<li><a href="<?= BASE_URL ?>user/profile"> <i class="fa fa-user"></i>Profil</a></li>