<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped display nowrap" id="tickets" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>Ticket No</th>
                    <th>Owner</th>
                    <th>Assign To</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Service</th>
                    <th>Sub Service</th>
                    <th>Action</th>
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
    $('#tickets').dataTable({
      responsive: true,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: {
        url: `<?= $link ?>`,
        header: 'application/json',
        type: 'POST',
      },
      columns: [{
          data: 'ticket_no',
        },
        {
          data: 'owner',
        },
        {
          data: 'assign_to'
        },
        {
          data: 'status',
          render: data => {
            if (data == 100) {
              return `<div class="badge badge-danger">Close</div>`
            } else if (data == 50) {
              return `<div class="badge badge-warning">In Progress</div>`
            } else {
              return `<div class="badge badge-success">Open</div>`
            }
          }
        },
        {
          data: 'priority',
          render: data => {
            if (data == 'Low') {
              return `<div class="badge badge-success">${data}</div>`
            } else if (data == 'Medium') {
              return `<div class="badge badge-warning">${data}</div>`
            } else if (data == 'High') {
              return `<div class="badge badge-danger">${data}</div>`
            } else if (data == 'Critical') {
              return `<div class="badge badge-dark">${data}</div>`
            }
          }
        },
        {
          data: 'service'
        },
        {
          data: 'subservice'
        },
        {
          data: 'action'
        }
      ]
    })
  });
</script>