<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUser">
              Add New User
            </button>
            <div class="table-responsive mt-3">
              <table class="table table-striped display nowrap" id="users">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Username</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created On</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('user/add_user') ?>" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" aria-describedby="username" placeholder="Enter Username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
            </div>
            <div class="form-group">
              <label for="type">User Type</label>
              <select id="type" name="type" class="form-control">
                <option value=""> - Select -</option>
                <option value="10">User</option>
                <option value="60">Agent</option>
                <option value="80">Manager</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="application/javascript">
  $(function() {
    renderCustomHTML();
    $('#users').dataTable({
      responsive: true,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: {
        url: `<?= base_url('User/generateDatatable') ?>`,
        header: 'application/json',
        type: 'POST',
      },
      columns: [{
        data: 'name'
      }, {
        data: 'email'
      }, {
        data: 'mobile'
      }, {
        data: 'username',
      }, {
        data: 'type',
        render: data => {
          if (data == 80) {
            return `<div class="badge badge-warning">Manager</div>`
          } else if (data == 60) {
            return `<div class="badge badge-primary">Agent</div>`
          } else if (data == 10) {
            return `<div class="badge badge-success">User</div>`
          }
        }
      }, {
        data: 'status',
        render: data => {
          if (data == 1) {
            return `<div class="badge badge-success">Active</div>`
          } else {
            return `<div class="badge badge-danger">Non Active</div>`
          }
        }
      }, {
        data: 'created',
        render: data => {
          return '<span class="rel-time" data-value="' + data + '000">'
        }
      }]
    })
  });
</script>