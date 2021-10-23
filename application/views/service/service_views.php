<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped display nowrap" id="services">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Created</th>
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
    renderCustomHTML()
    $('#services').dataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ],
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
        data: 'name'
      }, {
        data: 'created',
        render: data => {
          return '<span class="rel-time" data-value="' + data + '000">'
        }
      }, {
        data: 'action'
      }]
    })
  });
</script>