<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card custom-border-radius">
          <div class="card-body">
            <?php if ($this->session->flashdata('update_success')) : ?>
              <div class="flash-data" data-type="success" data-flashdata="<?= $this->session->flashdata('update_success') ?>"></div>
              <?php unset($_SESSION['update_success']) ?>
            <?php endif; ?>
            <div class="table-responsive">
              <table class="table table-striped display nowrap" id="subservices" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Prioritas</th>
                    <th>Nama Layanan</th>
                    <th>Pembuatan</th>
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
<script type="module" src="<?= base_url('assets/js/pages/subservices/list_all.js') ?>"></script>