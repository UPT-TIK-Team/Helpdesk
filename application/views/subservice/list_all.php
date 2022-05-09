<?php if ($this->session->flashdata('success')) : ?>
  <div class="flash-data" data-type="success" data-flashdata="<?= $this->session->flashdata('success') ?>"></div>
  <?php unset($_SESSION['success']) ?>
<?php elseif ($this->session->flashdata('failed')) : ?>
  <div class="flash-data" data-type="failed" data-flashdata="<?= $this->session->flashdata('failed') ?>"></div>
  <?php unset($_SESSION['failed']) ?>
<?php endif; ?>
<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card custom-border-radius">
          <div class="card-body">
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