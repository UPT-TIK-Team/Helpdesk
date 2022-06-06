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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSymptom">
              Tambah Gejala Baru
            </button>
            <div class="table-responsive mt-3">
              <table class="table table-striped display nowrap" id="symptoms" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
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
  <!-- Modal -->
  <div class="modal fade" id="addSymptom" tabindex="-1" role="dialog" aria-labelledby="addSymptomLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSymptomLabel">Tambah Gejala</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('API/Expertsystem_API/addsymptom') ?>" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="symptom-name">Nama</label>
              <input type="text" class="form-control" id="symptom-name" name="symptom-name" aria-describedby="symptom-name" placeholder="Enter name of the symptom">
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
            <button type="submit" class="btn btn-primary" id="btn-add-symptom" disabled>Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="module" src="<?= base_url('assets/js/pages/expertsystem/all_symptoms.js') ?>"></script>