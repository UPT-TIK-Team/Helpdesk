<li><a href="<?= BASE_URL ?>user/dashboard"> <i class="fa fa-home"></i>Dashboard </a></li>

<li><a href="#ticketsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list"></i>Tickets </a>
    <ul id="ticketsDropdown" class="collapse list-unstyled ">
        <li><a href="/tickets/create_new">New Ticket </a></li>
        <li><a href="/tickets/list_all">All Tickets</a></li>
        <li><a href="/tickets/unassigned_tickets">Unassigned Tickets</a></li>
        <li><a href="/tickets/assigned_tickets">Assigned Tickets</a></li>
        <li><a href="/tickets/closed_tickets" >Closed Ticket</a></li>
        <li><a href="/tickets/my_tickets" title="Created by me">My Tickets</a></li>
        <li><a href="/tickets/cc_to_me">Following</a></li>
    </ul>
</li>

<li><a href="#usersDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-users"></i>Users </a>
    <ul id="usersDropdown" class="collapse list-unstyled ">
        <li><a href="/user/list">All Users</a></li>
        <li><a href="/user/add_user">Add User</a></li>
        
    </ul>
</li>
<li><a href="/user/profile"> <i class="fa fa-user"></i>Profile </a></li>
