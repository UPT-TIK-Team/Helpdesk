<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped display nowrap" id="subservices">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Priority</th>
                    <th>Name Service</th>
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
<script>
  const link = `<?= $link ?>`
</script>
<script type="module" src="<?= base_url('assets/js/pages/subservices/list_all.js') ?>"></script>