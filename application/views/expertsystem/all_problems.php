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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProblems">
              Tambah Masalah Baru
            </button>
            <div class="table-responsive mt-3">
              <table class="table table-striped display nowrap" id="problems" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
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
  <!-- Modal -->
  <div class="modal fade" id="addProblems" tabindex="-1" role="dialog" aria-labelledby="addProblemsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProblemsLabel">Tambah Masalah</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('API/Expertsystem_API/addproblem') ?>" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="problem-name">Nama</label>
              <input type="text" class="form-control" id="problem-name" name="problem-name" aria-describedby="problem-name" placeholder="Masukkan nama masalah">
            </div>
            <div class="form-group">
              <label for="solution">Solusi</label>
              <input type="text" class="form-control" id="solution" name="solution" aria-describedby="solution" placeholder="Masukkan solusi">
              <small class="text-danger">*Jika solusi lebih dari 1, pisahkan dengan tanda titik koma (;)</small>
            </div>
            <div class="form-group">
              <label for="service">Layanan</label>
              <select class="form-control" name="service" id="service" style="width: 100%;">
                <option value="">Pilih Layanan</option>
              </select>
            </div>
            <div class="form-group">
              <label for="subservice">Sub Layanan</label>
              <select class="form-control" name="subservice" id="subservice" style="width: 100%;" disabled>
                <option value="">Pilih Sub Layanan</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn-add-problem" disabled>Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="module" src="<?= base_url('assets/js/pages/expertsystem/all_problems.js') ?>"></script>