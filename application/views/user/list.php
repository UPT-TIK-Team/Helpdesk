<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="table-responsive">
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

    // var options = {
    //   datatable: {
    //     columns: [{
    //         title: "ID",
    //         data: "id",
    //         render: function(data) {
    //           return data
    //         }
    //       },
    //       {
    //         title: "Name",
    //         data: "name",
    //         render: function(data) {
    //           return data;
    //         }
    //       },
    //       {
    //         title: "Email",
    //         data: "email",
    //         render: function(data) {
    //           return data;
    //         }
    //       },
    //       {
    //         title: "Mobile",
    //         data: "mobile",
    //         render: function(data) {
    //           return data ? data : '-'
    //         }
    //       },
    //       {
    //         title: "Username",
    //         data: "username",
    //         render: function(data) {
    //           return '<span class="user-name" data-username="' + data + '"></span>';
    //         }
    //       },
    //       {
    //         title: "Type",
    //         data: "type",
    //         render: function(data, type, row) {
    //           return '<span class="user-type" data-value="' + data + '"></span>'
    //         }
    //       },
    //       {
    //         title: "Status",
    //         data: "status",
    //         render: function(data, type, row) {
    //           // return '<span class="user-status" data-value="'+data+'"></span>'
    //           return '<a href="' + BASE_URL + 'user/profile_update/' + data + '" style="color: gray; text-decoration:none;">' + '<span class="user-status" data-value="' + data + '"></span>' + '</a>'
    //         }
    //       },
    //       {
    //         title: "Created On",
    //         data: "created",
    //         render: function(data) {
    //           return data ? '<span class="rel-time" data-value="' + data + '000">' : '-';
    //         }
    //       },
    //     ]
    //   }
    // };
    // var my_tik_table = makeReportPage($('#users'), 'list_users', options, function(err, data) {
    //   data.table.on('draw', function() {
    //     renderCustomHTML();
    //     $('[data-toggle="tooltip"]').tooltip();
    //   })
    // });



  });
</script>