<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped display nowrap" id="tickets">
                <thead>
                  <tr>
                    <th>Ticket No</th>
                    <th>Owner</th>
                    <th>Purpose</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Assign To</th>
                    <th>Assign On</th>
                    <th>Status</th>
                    <th>Severity</th>
                    <th>Priority</th>
                    <th>Data</th>
                    <th>Service</th>
                    <th>Sub Service</th>
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
        url: `${BASE_URL}API/Ticket/GetAllTickets`,
        header: 'application/json',
        type: 'POST',
      },
      columns: [{
          data: 0
        }, {
          data: 1
        }, {
          data: 2
        }, {
          data: 3
        }, {
          data: 4
        }, {
          data: 5
        }, {
          data: 6
        }, {
          data: 7
        },
        {
          data: 8,
          render: function(data, type, row) {
            if (data == 'Low') {
              return `<div class="badge badge-success">${data}</div>`
            } else if (data == 'Medium') {
              return `<div class="badge badge-warning">${data}</div>`
            } else if (data == 'High') {
              return `<div class="badge badge-danger">${data}</div>`
            }
          }
        },
        {
          data: 9
        },
        {
          data: 10
        },
        {
          data: 11
        },
        {
          data: 12
        },
      ]
    })
  });
</script>