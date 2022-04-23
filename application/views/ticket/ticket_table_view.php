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
                    <th>No Tiket</th>
                    <th>Pemilik</th>
                    <th>Ditugaskan</th>
                    <th>Status</th>
                    <th>Prioritas</th>
                    <th>Layanan</th>
                    <th>Sub Layanan</th>
                    <th>Aksi</th>
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