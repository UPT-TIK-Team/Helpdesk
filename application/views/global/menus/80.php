<li><a href="<?= BASE_URL ?>user/dashboard"> <i class="fa fa-home"></i>Dashboard </a></li>

<li><a href="#ticketsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list"></i>Tickets </a>
  <ul id="ticketsDropdown" class="collapse list-unstyled ">
    <li><a href="<?= BASE_URL ?>tickets/create_new">New Ticket </a></li>
    <li><a href="<?= BASE_URL ?>tickets/list_all">All Tickets</a></li>
    <li><a href="<?= BASE_URL ?>tickets/unassigned_tickets">Unassigned Tickets</a></li>
    <li><a href="<?= BASE_URL ?>tickets/assigned_tickets">Assigned Tickets</a></li>
    <li><a href="<?= BASE_URL ?>tickets/closed_tickets">Closed Ticket</a></li>
    <li><a href="<?= BASE_URL ?>tickets/my_tickets" title="Created by me">My Tickets</a></li>
  </ul>
</li>

<li><a href="#usersDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-users"></i>Users </a>
  <ul id="usersDropdown" class="collapse list-unstyled ">
    <li><a href="<?= BASE_URL ?>user/list">All Users</a></li>
  </ul>
</li>


<li><a href="#masterMenuDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-archive"></i>Master</a>
  <ul id="masterMenuDropdown" class="collapse list-unstyled ">
    <li><a href="<?= base_url('services/list_all') ?>">All Services</a></li>
    <li><a href="<?= base_url('subservices/list_all') ?>">All Subservices</a></li>
  </ul>
</li>

<li><a href="<?= BASE_URL ?>expertsystem/diagnose"> <i class="fa fa-globe"></i>Expert System </a></li>

<li><a href="<?= BASE_URL ?>user/profile"> <i class="fa fa-user"></i>Profile </a></li>