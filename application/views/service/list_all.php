<!-- Handle alert -->
<?php if ($this->session->flashdata('failed')) : ?>
  <div class="flash-data" data-type="failed" data-flashdata="<?= $this->session->flashdata('failed')  ?>"></div>
  <?php unset($_SESSION['failed']) ?>
<?php elseif ($this->session->flashdata('success')) : ?>
  <div class="flash-data" data-type="success" data-flashdata="<?= $this->session->flashdata('success')  ?>"></div>
  <?php unset($_SESSION['success']) ?>
<?php endif; ?>
<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped display nowrap" id="services" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>Nama</th>
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
<script type="module" src="<?= base_url('assets/js/pages/services/list_all.js') ?>"></script>