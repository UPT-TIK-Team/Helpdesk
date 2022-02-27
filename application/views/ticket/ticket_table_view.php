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
<script>
  const link = `<?= $link ?>`
</script>
<script type="module" src="<?= base_url('assets/js/pages/tickets/TicketTable.js') ?>"></script>